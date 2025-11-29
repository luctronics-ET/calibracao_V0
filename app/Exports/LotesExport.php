<?php

namespace App\Exports;

use App\Models\LoteEnvio;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LotesExport
{
    public function export($filters = [])
    {
        $query = LoteEnvio::with(['laboratorio', 'itens.equipamento']);

        // Apply filters
        if (!empty($filters['numero_lote'])) {
            $query->where('numero_lote', 'like', '%' . $filters['numero_lote'] . '%');
        }
        if (!empty($filters['laboratorio_id'])) {
            $query->where('laboratorio_id', $filters['laboratorio_id']);
        }
        if (!empty($filters['data_inicio'])) {
            $query->whereDate('data_envio', '>=', $filters['data_inicio']);
        }
        if (!empty($filters['data_fim'])) {
            $query->whereDate('data_envio', '<=', $filters['data_fim']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $lotes = $query->orderBy('data_envio', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title
        $sheet->setTitle('Lotes de Envio');

        // Header row
        $headers = [
            'A1' => 'Número Lote',
            'B1' => 'Data Envio',
            'C1' => 'Previsão Retorno',
            'D1' => 'Data Retorno',
            'E1' => 'Laboratório',
            'F1' => 'Qtd. Equipamentos',
            'G1' => 'Status',
            'H1' => 'Observações'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '667eea']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Data rows
        $row = 2;
        foreach ($lotes as $lote) {
            $sheet->setCellValue('A' . $row, $lote->numero_lote);
            $sheet->setCellValue('B' . $row, $lote->data_envio->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $lote->previsao_retorno?->format('d/m/Y'));
            $sheet->setCellValue('D' . $row, $lote->data_retorno?->format('d/m/Y'));
            $sheet->setCellValue('E' . $row, $lote->laboratorio->nome);
            $sheet->setCellValue('F' . $row, $lote->itens->count());
            $sheet->setCellValue('G' . $row, $this->translateStatus($lote->status));
            $sheet->setCellValue('H' . $row, $lote->observacoes);

            // Style data row
            $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ]
            ]);

            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    public function download($filters = [])
    {
        $spreadsheet = $this->export($filters);
        $writer = new Xlsx($spreadsheet);

        $filename = 'lotes_envio_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);

        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function translateStatus($status)
    {
        $statuses = [
            'preparacao' => 'Em Preparação',
            'enviado' => 'Enviado',
            'em_calibracao' => 'Em Calibração',
            'retornado' => 'Retornado',
            'cancelado' => 'Cancelado'
        ];

        return $statuses[$status] ?? $status;
    }
}

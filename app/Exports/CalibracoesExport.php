<?php

namespace App\Exports;

use App\Models\Calibracao;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CalibracoesExport
{
    public function export($filters = [])
    {
        $query = Calibracao::with(['equipamento', 'laboratorio']);

        // Apply filters
        if (!empty($filters['equipamento_id'])) {
            $query->where('equipamento_id', $filters['equipamento_id']);
        }
        if (!empty($filters['laboratorio_id'])) {
            $query->where('laboratorio_id', $filters['laboratorio_id']);
        }
        if (!empty($filters['data_inicio'])) {
            $query->whereDate('data_calibracao', '>=', $filters['data_inicio']);
        }
        if (!empty($filters['data_fim'])) {
            $query->whereDate('data_calibracao', '<=', $filters['data_fim']);
        }
        if (!empty($filters['resultado'])) {
            $query->where('resultado', $filters['resultado']);
        }

        $calibracoes = $query->orderBy('data_calibracao', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title
        $sheet->setTitle('Calibrações');

        // Header row
        $headers = [
            'A1' => 'Certificado',
            'B1' => 'Data Calibração',
            'C1' => 'Data Validade',
            'D1' => 'Equipamento',
            'E1' => 'Patrimônio',
            'F1' => 'Laboratório',
            'G1' => 'Resultado',
            'H1' => 'Custo',
            'I1' => 'Observações'
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
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        // Data rows
        $row = 2;
        foreach ($calibracoes as $calibracao) {
            $sheet->setCellValue('A' . $row, $calibracao->numero_certificado);
            $sheet->setCellValue('B' . $row, $calibracao->data_calibracao->format('d/m/Y'));
            $sheet->setCellValue('C' . $row, $calibracao->data_validade?->format('d/m/Y'));
            $sheet->setCellValue('D' . $row, $calibracao->equipamento->descricao);
            $sheet->setCellValue('E' . $row, $calibracao->equipamento->numero_patrimonio);
            $sheet->setCellValue('F' . $row, $calibracao->laboratorio->nome);
            $sheet->setCellValue('G' . $row, $this->translateResultado($calibracao->resultado));
            $sheet->setCellValue('H' . $row, 'R$ ' . number_format($calibracao->custo, 2, ',', '.'));
            $sheet->setCellValue('I' . $row, $calibracao->observacoes);

            // Style data row
            $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
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
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    public function download($filters = [])
    {
        $spreadsheet = $this->export($filters);
        $writer = new Xlsx($spreadsheet);

        $filename = 'calibracoes_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);

        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function translateResultado($resultado)
    {
        $resultados = [
            'aprovado' => 'Aprovado',
            'reprovado' => 'Reprovado',
            'condicional' => 'Condicional'
        ];

        return $resultados[$resultado] ?? $resultado;
    }
}

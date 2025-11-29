<?php

namespace App\Exports;

use App\Models\Equipamento;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EquipamentosExport
{
    public function export($filters = [])
    {
        $query = Equipamento::query();

        // Apply filters
        if (!empty($filters['numero_patrimonio'])) {
            $query->where('numero_patrimonio', 'like', '%' . $filters['numero_patrimonio'] . '%');
        }
        if (!empty($filters['descricao'])) {
            $query->where('descricao', 'like', '%' . $filters['descricao'] . '%');
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['status_calibracao'])) {
            $query->where('status_calibracao', $filters['status_calibracao']);
        }

        $equipamentos = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title
        $sheet->setTitle('Equipamentos');

        // Header row
        $headers = [
            'A1' => 'Código Interno',
            'B1' => 'Tipo',
            'C1' => 'Fabricante',
            'D1' => 'Modelo',
            'E1' => 'Série',
            'F1' => 'Local Físico',
            'G1' => 'Ciclo (meses)',
            'H1' => 'Criticidade',
            'I1' => 'Próxima Calibração',
            'J1' => 'Status Calibração'
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
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        // Data rows
        $row = 2;
        foreach ($equipamentos as $equipamento) {
            $sheet->setCellValue('A' . $row, $equipamento->codigo_interno);
            $sheet->setCellValue('B' . $row, $equipamento->tipo);
            $sheet->setCellValue('C' . $row, $equipamento->fabricante);
            $sheet->setCellValue('D' . $row, $equipamento->modelo);
            $sheet->setCellValue('E' . $row, $equipamento->serie);
            $sheet->setCellValue('F' . $row, $equipamento->local_fisico_atual);
            $sheet->setCellValue('G' . $row, $equipamento->ciclo_meses);
            $sheet->setCellValue('H' . $row, $this->translateCriticidade($equipamento->criticidade));
            $sheet->setCellValue('I' . $row, $equipamento->data_proxima_calibracao?->format('d/m/Y'));
            $sheet->setCellValue('J' . $row, $this->translateStatus($equipamento->status_calibracao));

            // Style data row
            $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
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
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return $spreadsheet;
    }

    public function download($filters = [])
    {
        $spreadsheet = $this->export($filters);
        $writer = new Xlsx($spreadsheet);

        $filename = 'equipamentos_' . date('Y-m-d_H-i-s') . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $filename);

        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function translateStatus($status)
    {
        $statuses = [
            'vencida' => 'Vencida',
            'critica' => 'Crítica (≤7d)',
            'proxima' => 'Próxima (≤30d)',
            'em_dia' => 'Em dia',
            'sem_calibracao' => 'Sem calibração'
        ];

        return $statuses[$status] ?? $status;
    }

    private function translateCriticidade($criticidade)
    {
        $criticidades = [
            'critica' => 'Crítica',
            'alta' => 'Alta',
            'media' => 'Média',
            'baixa' => 'Baixa'
        ];

        return $criticidades[$criticidade] ?? $criticidade;
    }
}

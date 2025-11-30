<?php

namespace App\Console\Commands;

use App\Models\Equipamento;
use App\Models\Laboratorio;
use App\Models\Calibracao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportCalibracaoCsvCommand extends Command
{
    protected $signature = 'import:calibracao-csv {file=calibracao.csv}';
    protected $description = 'Importa dados do CSV de calibração (67 colunas, 484 equipamentos)';

    private $stats = [
        'equipamentos_criados' => 0,
        'equipamentos_atualizados' => 0,
        'laboratorios_criados' => 0,
        'calibracoes_criadas' => 0,
        'erros' => [],
    ];

    public function handle()
    {
        $filePath = base_path($this->argument('file'));

        if (!file_exists($filePath)) {
            $this->error("Arquivo não encontrado: {$filePath}");
            return 1;
        }

        $this->info("Importando dados de: {$filePath}");

        DB::beginTransaction();

        try {
            $this->processCSV($filePath);

            DB::commit();

            $this->displayStats();

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Erro durante importação: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }

    private function processCSV($filePath)
    {
        $file = fopen($filePath, 'r');
        $lineNumber = 0;
        $laboratorios = [];

        while (($row = fgetcsv($file)) !== false) {
            $lineNumber++;

            // Pular linhas de cabeçalho (primeiras 3 linhas)
            if ($lineNumber <= 3) {
                continue;
            }

            // Validar se tem dados suficientes
            if (count($row) < 67) {
                $this->stats['erros'][] = "Linha {$lineNumber}: menos de 67 colunas";
                continue;
            }

            try {
                $this->processRow($row, $lineNumber, $laboratorios);
            } catch (\Exception $e) {
                $this->stats['erros'][] = "Linha {$lineNumber}: " . $e->getMessage();
            }
        }

        fclose($file);
    }

    private function processRow($row, $lineNumber, &$laboratorios)
    {
        // Mapear colunas conforme análise do CSV
        $data = [
            'classe' => $this->cleanValue($row[0]),
            'tipo' => $this->cleanValue($row[1]),
            'fabricante' => $this->cleanValue($row[2]),
            'modelo' => $this->cleanValue($row[3]),
            'serie' => $this->cleanValue($row[4]),
            'especificacoes' => $this->cleanValue($row[14]),
            'ciclo_meses' => $this->cleanValue($row[27]) ?: 12,
            'codigo_interno' => $this->cleanValue($row[28]),
            'patrimonio' => $this->cleanValue($row[32]),
            'data_ultima_calibracao' => $this->parseDate($row[50]),
            'data_validade_certificado' => $this->parseDate($row[51]),
            'data_proxima_calibracao' => $this->parseDate($row[53]),
            'custo_calibracao' => $this->parseDecimal($row[56]),
            'status' => $this->cleanValue($row[58]),
            'certificado_numero' => $this->cleanValue($row[59]),
            'laboratorio_nome' => $this->cleanValue($row[60]),
            'orcamento_valor' => $this->parseDecimal($row[63]),
            'setor' => $this->cleanValue($row[66]),
        ];

        // Validação básica
        if (empty($data['tipo'])) {
            throw new \Exception("Tipo de equipamento não informado");
        }

        // Criar ou atualizar laboratório
        $laboratorio = null;
        if (!empty($data['laboratorio_nome'])) {
            if (!isset($laboratorios[$data['laboratorio_nome']])) {
                $laboratorio = Laboratorio::firstOrCreate(
                    ['nome' => $data['laboratorio_nome']],
                    [
                        'endereco' => '',
                        'telefone' => '',
                        'email' => '',
                        'acreditacao' => true,
                    ]
                );
                $laboratorios[$data['laboratorio_nome']] = $laboratorio;
                $this->stats['laboratorios_criados']++;
            } else {
                $laboratorio = $laboratorios[$data['laboratorio_nome']];
            }
        }

        // Criar ou atualizar equipamento
        $equipamento = null;
        if (!empty($data['codigo_interno'])) {
            $equipamento = Equipamento::where('codigo_interno', $data['codigo_interno'])->first();
        }

        if ($equipamento) {
            $equipamento->update([
                'classe' => $data['classe'],
                'tipo' => $data['tipo'],
                'fabricante' => $data['fabricante'],
                'modelo' => $data['modelo'],
                'serie' => $data['serie'],
                'especificacoes' => $data['especificacoes'],
                'ciclo_meses' => $data['ciclo_meses'],
                'patrimonio' => $data['patrimonio'],
                'status' => $data['status'],
                'setor' => $data['setor'],
                'data_proxima_calibracao' => $data['data_proxima_calibracao'],
                'custo_estimado' => $data['orcamento_valor'],
            ]);
            $this->stats['equipamentos_atualizados']++;
        } else {
            $equipamento = Equipamento::create([
                'classe' => $data['classe'],
                'tipo' => $data['tipo'],
                'fabricante' => $data['fabricante'],
                'modelo' => $data['modelo'],
                'serie' => $data['serie'],
                'especificacoes' => $data['especificacoes'],
                'codigo_interno' => $data['codigo_interno'] ?: "AUTO-{$lineNumber}",
                'ciclo_meses' => $data['ciclo_meses'],
                'patrimonio' => $data['patrimonio'],
                'status' => $data['status'],
                'setor' => $data['setor'],
                'data_proxima_calibracao' => $data['data_proxima_calibracao'],
                'custo_estimado' => $data['orcamento_valor'],
                'status_calibracao' => $this->determineCalibrationStatus($data['status']),
            ]);
            $this->stats['equipamentos_criados']++;
        }

        // Criar registro de calibração se houver data
        if ($equipamento && $laboratorio && $data['data_ultima_calibracao']) {
            $calibracao = Calibracao::create([
                'equipamento_id' => $equipamento->id,
                'laboratorio_id' => $laboratorio->id,
                'data_calibracao' => $data['data_ultima_calibracao'],
                'data_validade' => $data['data_validade_certificado'] ?: $data['data_proxima_calibracao'],
                'certificado' => $data['certificado_numero'],
                'status' => 'concluida',
                'custo' => $data['custo_calibracao'],
                'observacoes' => "Importado do CSV linha {$lineNumber}",
            ]);
            $this->stats['calibracoes_criadas']++;
        }

        if ($lineNumber % 50 == 0) {
            $this->info("Processadas {$lineNumber} linhas...");
        }
    }

    private function cleanValue($value)
    {
        $cleaned = trim($value);
        return ($cleaned === '' || $cleaned === '#VALOR!' || $cleaned === 'NULL') ? null : $cleaned;
    }

    private function parseDate($value)
    {
        $cleaned = $this->cleanValue($value);
        if (!$cleaned) {
            return null;
        }

        try {
            // Tentar formatos: DD/MM/YY, DD/MM/YYYY
            if (preg_match('/^(\d{2})\/(\d{2})\/(\d{2,4})$/', $cleaned, $matches)) {
                $day = $matches[1];
                $month = $matches[2];
                $year = $matches[3];

                // Se ano com 2 dígitos, assumir 20XX
                if (strlen($year) == 2) {
                    $year = '20' . $year;
                }

                return Carbon::createFromFormat('d/m/Y', "{$day}/{$month}/{$year}")->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    private function parseDecimal($value)
    {
        $cleaned = $this->cleanValue($value);
        if (!$cleaned) {
            return null;
        }

        // Remover espaços e substituir vírgula por ponto
        $cleaned = str_replace([' ', ','], ['', '.'], $cleaned);

        if (is_numeric($cleaned)) {
            return floatval($cleaned);
        }

        return null;
    }

    private function determineCalibrationStatus($status)
    {
        if (!$status) {
            return 'pendente';
        }

        $status = strtoupper($status);

        if (str_contains($status, 'CALIBRADO') && !str_contains($status, 'DESCALIBRADO')) {
            return 'em_dia';
        }

        if (str_contains($status, 'DESCALIBRADO') || str_contains($status, 'VENCIDO')) {
            return 'vencido';
        }

        return 'pendente';
    }

    private function displayStats()
    {
        $this->newLine();
        $this->info('✓ Importação concluída!');
        $this->newLine();

        $this->table(
            ['Métrica', 'Quantidade'],
            [
                ['Equipamentos criados', $this->stats['equipamentos_criados']],
                ['Equipamentos atualizados', $this->stats['equipamentos_atualizados']],
                ['Laboratórios criados', $this->stats['laboratorios_criados']],
                ['Calibrações criadas', $this->stats['calibracoes_criadas']],
                ['Erros', count($this->stats['erros'])],
            ]
        );

        if (count($this->stats['erros']) > 0) {
            $this->newLine();
            $this->warn('Erros encontrados:');
            foreach (array_slice($this->stats['erros'], 0, 10) as $erro) {
                $this->error("  - {$erro}");
            }

            if (count($this->stats['erros']) > 10) {
                $this->warn("  ... e mais " . (count($this->stats['erros']) - 10) . " erros");
            }
        }
    }
}

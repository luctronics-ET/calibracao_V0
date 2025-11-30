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
    protected $description = 'Importa dados do CSV de calibração (67 colunas, 580+ linhas)';

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
        $equipamentos = [];

        while (($row = fgetcsv($file)) !== false) {
            $lineNumber++;

            // Linha 1: Cabeçalho principal (seções)
            // Linha 2: Nomes das colunas
            // Linha 3+: Dados
            if ($lineNumber <= 2) {
                continue;
            }

            // Validar se tem dados suficientes
            if (count($row) < 67) {
                $this->stats['erros'][] = "Linha {$lineNumber}: menos de 67 colunas (" . count($row) . " colunas)";
                continue;
            }

            try {
                $this->processRow($row, $lineNumber, $laboratorios, $equipamentos);
            } catch (\Exception $e) {
                $this->stats['erros'][] = "Linha {$lineNumber}: " . $e->getMessage();
            }
        }

        fclose($file);
    }

    private function processRow($row, $lineNumber, &$laboratorios, &$equipamentos)
    {
        // MAPEAMENTO CORRETO DAS COLUNAS DO CSV (conforme linha 2)
        $data = [
            // Especificações Técnicas (0-14)
            'classe' => $this->cleanValue($row[0]),
            'tipo' => $this->cleanValue($row[1]),
            'fabricante' => $this->cleanValue($row[2]),
            'modelo' => $this->cleanValue($row[3]),
            'serie' => $this->cleanValue($row[4]),
            'codigo_interno' => $this->cleanValue($row[5]),
            'altura' => $this->cleanValue($row[6]),
            'largura' => $this->cleanValue($row[7]),
            'comprimento' => $this->cleanValue($row[8]),
            'tensao' => $this->cleanValue($row[9]),
            'potencia' => $this->cleanValue($row[10]),
            'faixa_medicao' => $this->cleanValue($row[14]),

            // Metrologia (15-26)
            'unidade_medicao' => $this->cleanValue($row[15]),
            'tolerancia' => $this->cleanValue($row[16]),
            'status_prontidao' => $this->cleanValue($row[25]),
            'prioridade' => $this->cleanValue($row[26]),

            // Gestão (27-35)
            'ciclo_meses' => $this->cleanValue($row[27]) ?: 12,
            'divisao_setor' => $this->cleanValue($row[28]),
            'incumbencia' => $this->cleanValue($row[29]),
            'cadbem' => $this->cleanValue($row[30]),
            'patrimonio' => $this->cleanValue($row[32]),

            // Processo (36-49)
            'contrato_ata' => $this->cleanValue($row[36]),
            'executor_laboratorio' => $this->cleanValue($row[48]),

            // Datas e Calibração (50-61)
            'data_entrada_oficina' => $this->parseDateBR($row[50]),
            'data_saida_calibracao' => $this->parseDateBR($row[51]),
            'lote_remessa' => $this->cleanValue($row[52]),
            'data_retorno_calibracao' => $this->parseDateBR($row[53]),
            'data_entrega_oficina' => $this->parseDateBR($row[54]),
            'data_ultima_calibracao' => $this->parseExcelDate($row[56]),
            'data_proxima_calibracao' => $this->parseExcelDate($row[57]),
            'validade_status' => $this->cleanValue($row[58]),
            'certificado_numero' => $this->cleanValue($row[59]),
            'localizacao_atual' => $this->cleanValue($row[60]),
            'comentarios' => $this->cleanValue($row[61]),

            // Financeiro (63-65)
            'custo_estimado' => $this->parseDecimal($row[63]),
            'orcamento' => $this->parseDecimal($row[64]),
            'pagamento' => $this->parseDecimal($row[65]),

            // Local (66)
            'local_calibracao' => $this->cleanValue($row[66]),
        ];

        // Validação básica
        if (empty($data['tipo'])) {
            throw new \Exception("Tipo de equipamento não informado");
        }

        // Determinar nome do laboratório
        $laboratorio_nome = $data['local_calibracao'] ?: $data['localizacao_atual'] ?: $data['executor_laboratorio'];

        // Criar ou recuperar laboratório
        $laboratorio = null;
        if (!empty($laboratorio_nome)) {
            if (!isset($laboratorios[$laboratorio_nome])) {
                $laboratorio = Laboratorio::firstOrCreate(
                    ['nome' => $laboratorio_nome],
                    [
                        'endereco' => '',
                        'telefone' => '',
                        'email' => '',
                        'acreditacao' => true,
                    ]
                );
                $laboratorios[$laboratorio_nome] = $laboratorio;
                $this->stats['laboratorios_criados']++;
            } else {
                $laboratorio = $laboratorios[$laboratorio_nome];
            }
        }

        // Criar chave única do equipamento
        $equipamento_key = implode('|', [
            $data['classe'],
            $data['tipo'],
            $data['fabricante'],
            $data['modelo'],
            $data['serie'] ?: '',
            $data['codigo_interno'] ?: '',
            $data['patrimonio'] ?: '',
        ]);

        // Verificar se equipamento já foi criado nesta importação
        if (isset($equipamentos[$equipamento_key])) {
            $equipamento = $equipamentos[$equipamento_key];
            $this->stats['equipamentos_atualizados']++;
        } else {
            // Buscar por código interno ou criar novo
            $equipamento = null;
            if (!empty($data['codigo_interno'])) {
                $equipamento = Equipamento::where('codigo_interno', $data['codigo_interno'])->first();
            }

            if (!$equipamento && !empty($data['patrimonio'])) {
                $equipamento = Equipamento::where('patrimonio', $data['patrimonio'])->first();
            }

            if ($equipamento) {
                // Atualizar equipamento existente
                $equipamento->update([
                    'classe' => $data['classe'],
                    'tipo' => $data['tipo'],
                    'fabricante' => $data['fabricante'],
                    'modelo' => $data['modelo'],
                    'serie' => $data['serie'],
                    'especificacoes' => $data['faixa_medicao'],
                    'ciclo_meses' => $data['ciclo_meses'],
                    'setor' => $data['divisao_setor'],
                    'custo_estimado' => $data['custo_estimado'],
                ]);
                $this->stats['equipamentos_atualizados']++;
            } else {
                // Criar novo equipamento
                $equipamento = Equipamento::create([
                    'classe' => $data['classe'],
                    'tipo' => $data['tipo'],
                    'fabricante' => $data['fabricante'],
                    'modelo' => $data['modelo'],
                    'serie' => $data['serie'],
                    'codigo_interno' => $data['codigo_interno'] ?: "AUTO-{$lineNumber}",
                    'patrimonio' => $data['patrimonio'],
                    'especificacoes' => $data['faixa_medicao'],
                    'ciclo_meses' => $data['ciclo_meses'],
                    'setor' => $data['divisao_setor'],
                    'custo_estimado' => $data['custo_estimado'],
                    'status_calibracao' => $this->determineCalibrationStatus($data['validade_status']),
                ]);
                $this->stats['equipamentos_criados']++;
            }

            $equipamentos[$equipamento_key] = $equipamento;
        }

        // Criar registro de calibração se houver data
        if ($equipamento && $laboratorio && $data['data_ultima_calibracao']) {
            $calibracao = Calibracao::create([
                'equipamento_id' => $equipamento->id,
                'laboratorio_id' => $laboratorio->id,
                'data_envio' => $data['data_saida_calibracao'],
                'data_calibracao' => $data['data_ultima_calibracao'],
                'data_retorno' => $data['data_retorno_calibracao'],
                'status' => 'concluida',
                'certificado_num' => $data['certificado_numero'],
                'custo' => $data['custo_estimado'],
                'observacoes' => $this->buildObservacoes($data, $lineNumber),
            ]);
            $this->stats['calibracoes_criadas']++;
        }

        if ($lineNumber % 50 == 0) {
            $this->info("Processadas {$lineNumber} linhas...");
        }
    }

    private function buildObservacoes($data, $lineNumber)
    {
        $obs = ["Importado do CSV linha {$lineNumber}"];

        if ($data['comentarios']) {
            $obs[] = "Comentários: " . $data['comentarios'];
        }

        if ($data['validade_status']) {
            $obs[] = "Status: " . $data['validade_status'];
        }

        if ($data['lote_remessa']) {
            $obs[] = "Lote: " . $data['lote_remessa'];
        }

        return implode(' | ', $obs);
    }

    private function cleanValue($value)
    {
        if (!isset($value)) {
            return null;
        }

        $cleaned = trim($value);
        return ($cleaned === '' || $cleaned === '#VALOR!' || $cleaned === 'NULL') ? null : $cleaned;
    }

    private function parseDateBR($value)
    {
        $cleaned = $this->cleanValue($value);
        if (!$cleaned) {
            return null;
        }

        try {
            // Formato: DD/MM/YY ou DD/MM/YYYY
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/', $cleaned, $matches)) {
                $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
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

    private function parseExcelDate($value)
    {
        $cleaned = $this->cleanValue($value);
        if (!$cleaned) {
            return null;
        }

        try {
            // Se for número (serial do Excel)
            if (is_numeric($cleaned)) {
                // Excel conta dias desde 30/12/1899
                $timestamp = ($cleaned - 25569) * 86400;
                return Carbon::createFromTimestamp($timestamp)->format('Y-m-d');
            }

            // Se for data no formato DD/MM/YY
            return $this->parseDateBR($cleaned);
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
                $this->line("  - {$erro}");
            }

            if (count($this->stats['erros']) > 10) {
                $this->warn("  ... e mais " . (count($this->stats['erros']) - 10) . " erros");
            }
        }
    }
}

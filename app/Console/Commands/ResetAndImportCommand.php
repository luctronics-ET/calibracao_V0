<?php

namespace App\Console\Commands;

use App\Models\Equipamento;
use App\Models\Laboratorio;
use App\Models\Calibracao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResetAndImportCommand extends Command
{
    protected $signature = 'db:reset-import {file=____referencias/calib_import.csv}';
    protected $description = 'Apaga todos os dados e importa do CSV';

    private $stats = [
        'equipamentos_criados' => 0,
        'laboratorios_criados' => 0,
        'calibracoes_criadas' => 0,
        'erros' => [],
    ];

    public function handle()
    {
        $this->warn('⚠️  Esta operação vai APAGAR TODOS os dados do banco!');
        if (!$this->confirm('Deseja continuar?', false)) {
            $this->info('Operação cancelada.');
            return 0;
        }

        $filePath = base_path($this->argument('file'));

        if (!file_exists($filePath)) {
            $this->error("Arquivo não encontrado: {$filePath}");
            return 1;
        }

        $this->info("📄 Arquivo: {$filePath}");

        DB::beginTransaction();

        try {
            // Apagar todos os dados
            $this->info('🗑️  Apagando dados...');

            // SQLite - desabilitar foreign keys temporariamente
            DB::statement('PRAGMA foreign_keys = OFF');

            DB::table('calibracoes')->delete();
            DB::table('equipamentos')->delete();
            DB::table('laboratorios')->delete();
            DB::table('lotes_envio')->delete();
            DB::table('lote_equipamentos')->delete();
            DB::table('solicitacoes')->delete();
            DB::table('transportes')->delete();
            DB::table('logistica_et')->delete();
            DB::table('logistica_eventos')->delete();

            // Reset autoincrement
            DB::statement('DELETE FROM sqlite_sequence');

            DB::statement('PRAGMA foreign_keys = ON');

            $this->info('✅ Dados apagados');

            // Importar CSV
            $this->info('📥 Importando CSV...');
            $this->processCSV($filePath);

            DB::commit();

            $this->displayStats();

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Erro: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }

    private function processCSV($filePath)
    {
        $file = fopen($filePath, 'r');
        $lineNumber = 0;
        $headers = [];
        $laboratorios = [];

        while (($row = fgetcsv($file)) !== false) {
            $lineNumber++;

            if ($lineNumber === 1) {
                $headers = $row;
                $this->info("📋 Colunas encontradas: " . count($headers));
                continue;
            }

            try {
                $data = array_combine($headers, $row);
                $this->processRow($data, $lineNumber, $laboratorios);

                if ($lineNumber % 50 === 0) {
                    $this->info("Processadas {$lineNumber} linhas...");
                }
            } catch (\Exception $e) {
                $this->stats['erros'][] = "Linha {$lineNumber}: " . $e->getMessage();
            }
        }

        fclose($file);
    }

    private function processRow($data, $lineNumber, &$laboratorios)
    {
        // Criar ou recuperar laboratório
        $laboratorio = null;
        $lab_nome = $this->cleanValue($data['equipamento_local_calibracao'] ?? '');

        if (!empty($lab_nome)) {
            if (!isset($laboratorios[$lab_nome])) {
                $laboratorio = Laboratorio::create([
                    'nome' => $lab_nome,
                    'cnpj' => '',
                    'endereco' => '',
                    'contato' => '',
                    'acreditado' => true,
                    'escopo' => $this->cleanValue($data['categoria_metrologica'] ?? ''),
                ]);
                $laboratorios[$lab_nome] = $laboratorio;
                $this->stats['laboratorios_criados']++;
            } else {
                $laboratorio = $laboratorios[$lab_nome];
            }
        }

        // Criar equipamento
        $equipamento_data = [
            'categoria_metrologica' => $this->cleanValue($data['categoria_metrologica'] ?? ''),
            'equipamento_tipo' => $this->cleanValue($data['equipamento_tipo'] ?? ''),
            'equipamento_fabricante' => $this->cleanValue($data['equipamento_fabricante'] ?? ''),
            'equipamento_modelo' => $this->cleanValue($data['equipamento_modelo'] ?? ''),
            'equipamento_faixa_medicao' => $this->cleanValue($data['equipamento_faixa_medicao'] ?? ''),
            'equipamento_codigo_interno' => $this->cleanValue($data['equipamento_codigo_interno'] ?? ''),
            'equipamento_serial' => $this->cleanValue($data['equipamento_serial'] ?? ''),
            'equipamento_setor' => $this->cleanValue($data['equipamento_setor'] ?? ''),
            'numero_ordem_servico' => $this->cleanValue($data['numero_ordem_servico'] ?? ''),
            'data_recebimento_et' => $this->parseDateDDMMYY($data['data_recebimento_et'] ?? ''),
            'data_saida_calibracao' => $this->parseDateDDMMYY($data['data_saida_calibracao'] ?? ''),
            'data_recebimento_calibracao' => $this->parseDateDDMMYY($data['data_recebimento_calibracao'] ?? ''),
            'equipamento_data_ultima_calibracao' => $this->parseDateDDMMYY($data['equipamento_data_ultima_calibracao'] ?? ''),
            'periodicidade_meses' => (int)($this->cleanValue($data['periodicidade_meses'] ?? '12')),
            'proxima_calibracao_prevista' => $this->parseDateDDMMYY($data['proxima_calibracao_prevista'] ?? ''),
            'equipamento_certificado_status' => $this->cleanValue($data['equipamento_certificado_status'] ?? ''),
            'equipamento_certificado_pdf' => $this->cleanValue($data['equipamento_certificado_pdf'] ?? ''),
            'equipamento_localizacao' => $this->cleanValue($data['equipamento_localizacao'] ?? ''),
            'equipamento_comentarios' => $this->cleanValue($data['equipamento_comentarios'] ?? ''),
            'custo_estimado' => $this->parseCurrency($data['custo_estimado'] ?? ''),
            'equipamento_local_calibracao' => $lab_nome,
            'equipamento_status' => 'ativo',
        ];

        // Validação básica
        if (empty($equipamento_data['equipamento_tipo'])) {
            throw new \Exception("Tipo de equipamento não informado");
        }

        $equipamento = Equipamento::create($equipamento_data);
        $this->stats['equipamentos_criados']++;

        // Criar calibração se houver data
        if (!empty($equipamento_data['equipamento_data_ultima_calibracao']) && $laboratorio) {
            try {
                Calibracao::create([
                    'equipamento_id' => $equipamento->id,
                    'laboratorio_id' => $laboratorio->id,
                    'data_envio' => $equipamento_data['data_saida_calibracao'],
                    'data_conclusao' => $equipamento_data['equipamento_data_ultima_calibracao'],
                    'data_validade' => $equipamento_data['proxima_calibracao_prevista'],
                    'resultado' => $equipamento_data['equipamento_certificado_status'] === 'CALIBRADO' ? 'aprovado' : 'reprovado',
                    'certificado' => $equipamento_data['equipamento_certificado_pdf'],
                    'observacoes' => $equipamento_data['equipamento_comentarios'],
                    'custo' => $equipamento_data['custo_estimado'],
                ]);
                $this->stats['calibracoes_criadas']++;
            } catch (\Exception $e) {
                // Ignorar erros de calibração
            }
        }
    }

    private function cleanValue($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        return trim($value);
    }

    private function parseDateDDMMYY($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Formato DD/MM/YY
            if (preg_match('/^(\d{2})\/(\d{2})\/(\d{2})$/', $date, $matches)) {
                $day = $matches[1];
                $month = $matches[2];
                $year = '20' . $matches[3]; // Assumir 20xx
                return Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-{$day}")->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    private function parseCurrency($value)
    {
        if (empty($value)) {
            return null;
        }

        // Remove R$, espaços, pontos de milhar
        $value = str_replace(['R$', ' ', '.'], '', $value);
        // Troca vírgula por ponto
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    private function displayStats()
    {
        $this->newLine();
        $this->info('✅ Importação concluída!');
        $this->newLine();

        $this->table(
            ['Item', 'Quantidade'],
            [
                ['Equipamentos criados', $this->stats['equipamentos_criados']],
                ['Laboratórios criados', $this->stats['laboratorios_criados']],
                ['Calibrações criadas', $this->stats['calibracoes_criadas']],
                ['Erros', count($this->stats['erros'])],
            ]
        );

        if (!empty($this->stats['erros'])) {
            $this->warn('Erros encontrados:');
            foreach (array_slice($this->stats['erros'], 0, 10) as $erro) {
                $this->error($erro);
            }
            if (count($this->stats['erros']) > 10) {
                $this->warn('... e mais ' . (count($this->stats['erros']) - 10) . ' erros.');
            }
        }
    }
}

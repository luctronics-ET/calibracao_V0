<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ExportEquipamentosTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:equipamentos-template {--format=csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporta template CSV com todas as colunas da tabela equipamentos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Exportando template de equipamentos...');

        // Obter todas as colunas da tabela
        $columns = Schema::getColumnListing('equipamentos');

        // Remover colunas automáticas se existirem
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at']);

        // Ordenar alfabeticamente para facilitar
        sort($columns);

        $format = $this->option('format');
        $filename = storage_path('app/public/equipamentos_template_' . date('Y-m-d_His') . '.' . $format);

        if ($format === 'csv') {
            $this->exportCsv($columns, $filename);
        }

        $this->info("✓ Template exportado com sucesso!");
        $this->info("📁 Arquivo: $filename");
        $this->info("📊 Total de colunas: " . count($columns));

        return 0;
    }

    private function exportCsv($columns, $filename)
    {
        $fp = fopen($filename, 'w');

        // Escrever cabeçalho
        fputcsv($fp, $columns, ';');

        // Escrever uma linha de exemplo vazia
        fputcsv($fp, array_fill(0, count($columns), ''), ';');

        // Escrever linha com descrição dos campos principais
        $descriptions = [];
        foreach ($columns as $column) {
            $descriptions[] = $this->getColumnDescription($column);
        }
        fputcsv($fp, $descriptions, ';');

        fclose($fp);
    }

    private function getColumnDescription($column)
    {
        $descriptions = [
            'divisao' => 'Divisão responsável pelo equipamento',
            'equipamento_tipo' => 'Tipo do equipamento (ex: Paquímetro, Micrômetro)',
            'equipamento_fabricante' => 'Fabricante do equipamento',
            'equipamento_modelo' => 'Modelo do equipamento',
            'equipamento_serial' => 'Número de série',
            'equipamento_codigo_interno' => 'Código interno da empresa',
            'equipamento_localizacao' => 'Localização física atual',
            'equipamento_setor' => 'Setor onde está alocado',
            'equipamento_status' => 'Status: ativo, inativo, manutencao, descartado',
            'equipamento_data_proxima_calibracao' => 'Data próxima calibração (YYYY-MM-DD)',
            'equipamento_periodicidade_meses' => 'Periodicidade em meses (ex: 12)',
            'equipamento_resolucao' => 'Resolução do equipamento',
            'equipamento_faixa_medicao' => 'Faixa de medição',
            'equipamento_classe' => 'Classe do equipamento',
            'equipamento_igp' => 'Índice de Grau de Prioridade (5-15)',
            'equipamento_classificacao' => 'Classificação: baixa, media, alta',
        ];

        return $descriptions[$column] ?? '';
    }
}

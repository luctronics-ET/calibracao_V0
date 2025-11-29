<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Equipamento;

class ImportEquipamentosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:equipamentos {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa equipamentos de uma planilha Excel/CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("Arquivo não encontrado: {$file}");
            return Command::FAILURE;
        }

        $this->info("Importando equipamentos de: {$file}");

        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove header row
            $headers = array_shift($rows);

            $imported = 0;
            $errors = 0;

            foreach ($rows as $index => $row) {
                try {
                    $data = array_combine($headers, $row);

                    Equipamento::create([
                        'divisao_origem' => $data['divisao_origem'] ?? null,
                        'tipo' => $data['tipo'] ?? null,
                        'categoria' => $data['categoria'] ?? null,
                        'fabricante' => $data['fabricante'] ?? null,
                        'modelo' => $data['modelo'] ?? null,
                        'serie' => $data['serie'] ?? null,
                        'codigo_interno' => $data['codigo_interno'] ?? null,
                        'descricao' => $data['descricao'] ?? null,
                        'local_fisico_atual' => $data['local_fisico_atual'] ?? null,
                        'ciclo_meses' => $data['ciclo_meses'] ?? 12,
                        'criticidade' => $data['criticidade'] ?? 'media',
                        'classe_metrologica' => $data['classe_metrologica'] ?? null,
                        'resolucao' => $data['resolucao'] ?? null,
                        'faixa_medicao' => $data['faixa_medicao'] ?? null,
                        'mpe' => $data['mpe'] ?? null,
                        'norma_aplicavel' => $data['norma_aplicavel'] ?? null,
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $this->warn("Erro na linha " . ($index + 2) . ": " . $e->getMessage());
                    $errors++;
                }
            }

            $this->info("✓ Importação concluída!");
            $this->info("  - {$imported} equipamentos importados");
            if ($errors > 0) {
                $this->warn("  - {$errors} erros encontrados");
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erro ao importar: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

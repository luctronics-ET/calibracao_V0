<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CalibracaoService;

class AtualizarProximasCalibracoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calibracao:atualizar-prazos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza as datas de próxima calibração de todos os equipamentos';

    protected $calibracaoService;

    public function __construct(CalibracaoService $calibracaoService)
    {
        parent::__construct();
        $this->calibracaoService = $calibracaoService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Atualizando datas de próxima calibração...');

        $atualizados = $this->calibracaoService->atualizarTodosEquipamentos();

        $this->info("✓ {$atualizados} equipamentos atualizados com sucesso!");

        // Mostrar estatísticas
        $vencidos = $this->calibracaoService->equipamentosVencidos()->count();
        $urgentes = $this->calibracaoService->equipamentosUrgentes(30)->count();

        $this->table(
            ['Status', 'Quantidade'],
            [
                ['Calibrações vencidas', $vencidos],
                ['Calibrações urgentes (30 dias)', $urgentes],
            ]
        );

        return 0;
    }
}

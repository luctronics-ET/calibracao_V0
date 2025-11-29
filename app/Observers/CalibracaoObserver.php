<?php

namespace App\Observers;

use App\Models\Calibracao;
use App\Services\CalibracaoService;

class CalibracaoObserver
{
    protected $calibracaoService;

    public function __construct(CalibracaoService $calibracaoService)
    {
        $this->calibracaoService = $calibracaoService;
    }

    /**
     * Handle the Calibracao "created" event.
     */
    public function created(Calibracao $calibracao): void
    {
        // Atualiza a próxima calibração do equipamento após criar nova calibração
        if ($calibracao->equipamento) {
            $this->calibracaoService->atualizarProximaCalibracao($calibracao->equipamento);
        }
    }

    /**
     * Handle the Calibracao "updated" event.
     */
    public function updated(Calibracao $calibracao): void
    {
        // Atualiza a próxima calibração do equipamento após atualizar calibração
        if ($calibracao->equipamento) {
            $this->calibracaoService->atualizarProximaCalibracao($calibracao->equipamento);
        }
    }

    /**
     * Handle the Calibracao "deleted" event.
     */
    public function deleted(Calibracao $calibracao): void
    {
        // Recalcula após deletar uma calibração
        if ($calibracao->equipamento) {
            $this->calibracaoService->atualizarProximaCalibracao($calibracao->equipamento);
        }
    }

    /**
     * Handle the Calibracao "restored" event.
     */
    public function restored(Calibracao $calibracao): void
    {
        // Recalcula após restaurar uma calibração
        if ($calibracao->equipamento) {
            $this->calibracaoService->atualizarProximaCalibracao($calibracao->equipamento);
        }
    }

    /**
     * Handle the Calibracao "force deleted" event.
     */
    public function forceDeleted(Calibracao $calibracao): void
    {
        //
    }
}

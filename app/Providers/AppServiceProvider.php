<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Calibracao;
use App\Models\Equipamento;
use App\Observers\CalibracaoObserver;
use App\Observers\EquipamentoObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Registrar observers
        Calibracao::observe(CalibracaoObserver::class);
        Equipamento::observe(EquipamentoObserver::class);
    }
}

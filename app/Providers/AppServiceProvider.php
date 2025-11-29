<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Calibracao;
use App\Observers\CalibracaoObserver;

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
        // Registrar observer de Calibracao
        Calibracao::observe(CalibracaoObserver::class);
    }
}

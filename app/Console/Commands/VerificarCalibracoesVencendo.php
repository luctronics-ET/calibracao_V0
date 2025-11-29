<?php

namespace App\Console\Commands;

use App\Models\Equipamento;
use App\Models\User;
use App\Notifications\CalibracaoVencendoNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class VerificarCalibracoesVencendo extends Command
{
    protected $signature = 'calibracao:verificar-vencimento {--dias=30 : Número de dias para considerar vencimento}';
    protected $description = 'Verifica e notifica calibrações que estão próximas do vencimento';

    public function handle()
    {
        $dias = (int) $this->option('dias');

        $this->info("🔍 Verificando equipamentos com calibração vencendo em até {$dias} dias...");

        $dataLimite = Carbon::now()->addDays($dias);

        $equipamentos = Equipamento::whereBetween('data_proxima_calibracao', [
            Carbon::now(),
            $dataLimite
        ])->get();

        if ($equipamentos->isEmpty()) {
            $this->info("✅ Nenhum equipamento com calibração vencendo nos próximos {$dias} dias.");
            return 0;
        }

        $this->info("⚠️  Encontrados {$equipamentos->count()} equipamento(s) com calibração vencendo:");
        $this->newLine();

        foreach ($equipamentos as $equipamento) {
            $dataProxima = $equipamento->data_proxima_calibracao instanceof Carbon
                ? $equipamento->data_proxima_calibracao
                : Carbon::parse($equipamento->data_proxima_calibracao);

            $diasRestantes = Carbon::now()->diffInDays($dataProxima);
            $this->line("📋 {$equipamento->codigo_interno} - {$equipamento->descricao}");
            $this->line("   Vence em: {$dataProxima->format('d/m/Y')} ({$diasRestantes} dias)");
            $this->newLine();
        }

        // Notificar usuários admin e tecnico
        $usuarios = User::whereIn('permissao', ['admin', 'tecnico'])->get();

        foreach ($usuarios as $usuario) {
            $usuario->notify(new CalibracaoVencendoNotification($equipamentos, $dias));
        }

        $this->info("📧 Notificações enviadas para {$usuarios->count()} usuário(s).");

        return 0;
    }
}

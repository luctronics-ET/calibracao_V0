<?php

namespace App\Console\Commands;

use App\Models\Calibracao;
use App\Models\Equipamento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckCalibrationDeadlines extends Command
{
    protected $signature = 'calibration:check-deadlines {--notify : Enviar notificações}';
    protected $description = 'Verifica calibrações vencidas e próximas do vencimento';

    public function handle()
    {
        $this->info('Verificando prazos de calibração...');

        // Calibrações vencidas
        $vencidas = Calibracao::where('data_proxima_calibracao', '<', now())
            ->where('status', 'em_uso')
            ->with('equipamento')
            ->get();

        // Calibrações vencendo em 30 dias
        $vencendo30 = Calibracao::whereBetween('data_proxima_calibracao', [
            now(),
            now()->addDays(30)
        ])
            ->where('status', 'em_uso')
            ->with('equipamento')
            ->get();

        // Calibrações vencendo em 60 dias
        $vencendo60 = Calibracao::whereBetween('data_proxima_calibracao', [
            now()->addDays(31),
            now()->addDays(60)
        ])
            ->where('status', 'em_uso')
            ->with('equipamento')
            ->get();

        // Exibir resultados
        $this->newLine();
        $this->error("🔴 VENCIDAS: {$vencidas->count()}");
        foreach ($vencidas as $cal) {
            $dias = now()->diffInDays($cal->data_proxima_calibracao);
            $this->line("  - {$cal->equipamento->codigo_interno} ({$cal->equipamento->tipo}) - Vencida há {$dias} dias");
        }

        $this->newLine();
        $this->warn("🟡 VENCENDO EM 30 DIAS: {$vencendo30->count()}");
        foreach ($vencendo30 as $cal) {
            $dias = now()->diffInDays($cal->data_proxima_calibracao);
            $this->line("  - {$cal->equipamento->codigo_interno} ({$cal->equipamento->tipo}) - Vence em {$dias} dias");
        }

        $this->newLine();
        $this->info("🟢 VENCENDO EM 60 DIAS: {$vencendo60->count()}");
        foreach ($vencendo60 as $cal) {
            $dias = now()->diffInDays($cal->data_proxima_calibracao);
            $this->line("  - {$cal->equipamento->codigo_interno} ({$cal->equipamento->tipo}) - Vence em {$dias} dias");
        }

        // Log
        Log::info('Verificação de prazos de calibração', [
            'vencidas' => $vencidas->count(),
            'vencendo_30_dias' => $vencendo30->count(),
            'vencendo_60_dias' => $vencendo60->count(),
        ]);

        $this->newLine();
        $this->info('✅ Verificação concluída!');

        return Command::SUCCESS;
    }
}

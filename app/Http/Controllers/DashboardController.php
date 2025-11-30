<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Calibracao;
use App\Models\Certificate;
use App\Models\LoteEnvio;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs principais
        $totalEquipamentos = Equipamento::count();
        $equipamentosAtivos = Equipamento::where('status', 'ativo')->count();
        $totalCalibracoes = Calibracao::count();
        $calibracoesAno = Calibracao::whereYear('data_calibracao', date('Y'))->count();

        // Vencimentos próximos (30 dias)
        $vencimentosProximos = Calibracao::whereBetween('data_proxima_calibracao', [
            now(),
            now()->addDays(30)
        ])->count();

        // Vencidos
        $vencidos = Calibracao::where('data_proxima_calibracao', '<', now())
            ->where('status', 'em_uso')
            ->count();

        // Distribuição por classificação IGP
        $distribuicaoIGP = Equipamento::select('classificacao', DB::raw('count(*) as total'))
            ->whereNotNull('classificacao')
            ->groupBy('classificacao')
            ->get()
            ->pluck('total', 'classificacao')
            ->toArray();

        // Calibrações por mês (últimos 12 meses)
        $calibracoesPorMes = Calibracao::select(
            DB::raw("strftime('%Y-%m', data_calibracao) as mes"),
            DB::raw('count(*) as total')
        )
            ->where('data_calibracao', '>=', now()->subMonths(12))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Top 5 equipamentos com mais calibrações
        $topEquipamentos = Equipamento::withCount('calibracoes')
            ->orderBy('calibracoes_count', 'desc')
            ->limit(5)
            ->get();

        // Certificados vencendo
        $certificadosVencendo = Certificate::whereBetween('data_validade', [
            now(),
            now()->addDays(30)
        ])->count();

        // Status dos lotes
        $lotesPorStatus = LoteEnvio::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        return view('dashboard', compact(
            'totalEquipamentos',
            'equipamentosAtivos',
            'totalCalibracoes',
            'calibracoesAno',
            'vencimentosProximos',
            'vencidos',
            'distribuicaoIGP',
            'calibracoesPorMes',
            'topEquipamentos',
            'certificadosVencendo',
            'lotesPorStatus'
        ));
    }
}

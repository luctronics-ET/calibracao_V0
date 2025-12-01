<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Calibracao;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs principais
        $totalEquipamentos = Equipamento::count();
        $equipamentosBloqueados = Equipamento::where('bloqueado_para_uso', 1)->count();
        $totalCalibracoes = Calibracao::count();
        $calibracoesAno = Calibracao::whereYear('data_calibracao', date('Y'))->count();

        // Vencimentos próximos (30 dias)
        $vencimentosProximos = Equipamento::whereBetween('proxima_calibracao_prevista', [
            now(),
            now()->addDays(30)
        ])->count();

        // Vencidos
        $vencidos = Equipamento::where('proxima_calibracao_prevista', '<', now())
            ->where('bloqueado_para_uso', 0)
            ->count();

        // Distribuição por criticidade
        $distribuicaoCriticidade = Equipamento::select('criticidade_equipamento', DB::raw('count(*) as total'))
            ->whereNotNull('criticidade_equipamento')
            ->groupBy('criticidade_equipamento')
            ->get()
            ->pluck('total', 'criticidade_equipamento')
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

        // Status dos lotes
        $lotesPorStatus = Lote::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        // Calibrações com RBC
        $calibracoesRBC = Calibracao::whereNotNull('rbc_codigo_laboratorio')->count();
        $calibracoesILAC = Calibracao::where('conformidade_ilac_p14', 1)->count();

        return view('dashboard', compact(
            'totalEquipamentos',
            'equipamentosBloqueados',
            'totalCalibracoes',
            'calibracoesAno',
            'vencimentosProximos',
            'vencidos',
            'distribuicaoCriticidade',
            'calibracoesPorMes',
            'topEquipamentos',
            'lotesPorStatus',
            'calibracoesRBC',
            'calibracoesILAC'
        ));
    }
}

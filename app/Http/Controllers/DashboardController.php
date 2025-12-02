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
        $equipamentosAtivos = Equipamento::where('equipamento_status', 'ativo')->count();

        // Calibrações vencidas
        $calibracoesVencidas = Equipamento::where('equipamento_data_proxima_calibracao', '<', now())
            ->whereNotNull('equipamento_data_proxima_calibracao')
            ->count();

        // A vencer nos próximos 30 dias
        $calibracoesAVencer = Equipamento::whereBetween('equipamento_data_proxima_calibracao', [
            now(),
            now()->addDays(30)
        ])->count();

        // Lotes ativos
        $lotesAtivos = Lote::where('status', 'ativo')->count();

        // Lista de equipamentos vencidos
        $equipamentosVencidosLista = Equipamento::where('equipamento_data_proxima_calibracao', '<', now())
            ->whereNotNull('equipamento_data_proxima_calibracao')
            ->orderBy('equipamento_data_proxima_calibracao', 'asc')
            ->get();

        // Lista de equipamentos a vencer nos próximos 30 dias
        $equipamentosAVencerLista = Equipamento::whereBetween('equipamento_data_proxima_calibracao', [
            now(),
            now()->addDays(30)
        ])->orderBy('equipamento_data_proxima_calibracao', 'asc')
            ->get();

        // Dados para gráfico de calibrações (últimos 12 meses)
        $calibracoesMeses = [
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            'data' => [5, 8, 12, 7, 10, 15, 9, 11, 14, 8, 6, 10]
        ];

        // Dados para gráfico de status dos equipamentos
        $statusData = [
            'labels' => ['Ativos', 'Inativos', 'Manutenção', 'Descartados'],
            'data' => [
                Equipamento::where('equipamento_status', 'ativo')->count(),
                Equipamento::where('equipamento_status', 'inativo')->count(),
                Equipamento::where('equipamento_status', 'manutencao')->count(),
                Equipamento::where('equipamento_status', 'descartado')->count()
            ]
        ];

        return view('dashboard.index', compact(
            'totalEquipamentos',
            'equipamentosAtivos',
            'calibracoesVencidas',
            'calibracoesAVencer',
            'lotesAtivos',
            'equipamentosVencidosLista',
            'equipamentosAVencerLista',
            'calibracoesMeses',
            'statusData'
        ));
    }
}

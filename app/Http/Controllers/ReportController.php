<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Calibracao;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Relatório de vencimentos
     */
    public function vencimentos(Request $request)
    {
        $dias = $request->get('dias', 30);

        $vencimentos = Calibracao::with('equipamento')
            ->whereBetween('data_proxima_calibracao', [
                now(),
                now()->addDays($dias)
            ])
            ->orderBy('data_proxima_calibracao')
            ->get();

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.vencimentos-pdf', compact('vencimentos', 'dias'));
            return $pdf->download('relatorio-vencimentos.pdf');
        }

        return view('reports.vencimentos', compact('vencimentos', 'dias'));
    }

    /**
     * Relatório de histórico de calibrações
     */
    public function historico(Request $request)
    {
        $query = Calibracao::with(['equipamento', 'laboratorio']);

        if ($request->has('equipamento_id')) {
            $query->where('equipamento_id', $request->equipamento_id);
        }

        if ($request->has('data_inicio')) {
            $query->where('data_calibracao', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim')) {
            $query->where('data_calibracao', '<=', $request->data_fim);
        }

        $calibracoes = $query->orderBy('data_calibracao', 'desc')->get();
        $equipamentos = Equipamento::orderBy('codigo_interno')->get();

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.historico-pdf', compact('calibracoes'));
            return $pdf->download('relatorio-historico.pdf');
        }

        return view('reports.historico', compact('calibracoes', 'equipamentos'));
    }

    /**
     * Relatório de análise de custos
     */
    public function custos(Request $request)
    {
        $ano = $request->get('ano', date('Y'));

        // Custos por mês
        $custosPorMes = Calibracao::select(
            DB::raw("strftime('%m', data_calibracao) as mes"),
            DB::raw('SUM(custo) as total_custo'),
            DB::raw('COUNT(*) as total_calibracoes')
        )
            ->whereYear('data_calibracao', $ano)
            ->whereNotNull('custo')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Custos por laboratório
        $custosPorLab = Calibracao::select(
            'laboratorios.nome',
            DB::raw('SUM(calibracoes.custo) as total_custo'),
            DB::raw('COUNT(*) as total_calibracoes'),
            DB::raw('AVG(calibracoes.custo) as media_custo')
        )
            ->join('laboratorios', 'calibracoes.laboratorio_id', '=', 'laboratorios.id')
            ->whereYear('calibracoes.data_calibracao', $ano)
            ->whereNotNull('calibracoes.custo')
            ->groupBy('laboratorios.id', 'laboratorios.nome')
            ->orderBy('total_custo', 'desc')
            ->get();

        // Custos por tipo de equipamento
        $custosPorTipo = Calibracao::select(
            'equipamentos.equipamento_tipo as tipo',
            DB::raw('SUM(calibracoes.custo) as total_custo'),
            DB::raw('COUNT(*) as total_calibracoes'),
            DB::raw('AVG(calibracoes.custo) as media_custo')
        )
            ->join('equipamentos', 'calibracoes.equipamento_id', '=', 'equipamentos.id')
            ->whereYear('calibracoes.data_calibracao', $ano)
            ->whereNotNull('calibracoes.custo')
            ->groupBy('equipamentos.equipamento_tipo')
            ->orderBy('total_custo', 'desc')
            ->get();

        $custoTotal = Calibracao::whereYear('data_calibracao', $ano)
            ->sum('custo');

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.custos-pdf', compact(
                'custosPorMes',
                'custosPorLab',
                'custosPorTipo',
                'custoTotal',
                'ano'
            ));
            return $pdf->download('relatorio-custos.pdf');
        }

        return view('reports.custos', compact(
            'custosPorMes',
            'custosPorLab',
            'custosPorTipo',
            'custoTotal',
            'ano'
        ));
    }

    /**
     * Relatório de estatísticas IGP
     */
    public function igp(Request $request)
    {
        // Distribuição por classificação
        $distribuicao = Equipamento::select('classificacao', DB::raw('COUNT(*) as total'))
            ->whereNotNull('classificacao')
            ->groupBy('classificacao')
            ->get();

        // Equipamentos de alta prioridade
        $altaPrioridade = Equipamento::where('classificacao', 'alta')
            ->with('calibracoes')
            ->get();

        // Média IGP por tipo
        $mediaPorTipo = Equipamento::select('tipo', DB::raw('AVG(igp) as media_igp'))
            ->whereNotNull('igp')
            ->groupBy('tipo')
            ->orderBy('media_igp', 'desc')
            ->get();

        // Equipamentos críticos sem calibração recente
        $criticosSemCalibracao = Equipamento::where('classificacao', 'alta')
            ->whereDoesntHave('calibracoes', function ($query) {
                $query->where('data_calibracao', '>', now()->subMonths(6));
            })
            ->get();

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.igp-pdf', compact(
                'distribuicao',
                'altaPrioridade',
                'mediaPorTipo',
                'criticosSemCalibracao'
            ));
            return $pdf->download('relatorio-igp.pdf');
        }

        return view('reports.igp', compact(
            'distribuicao',
            'altaPrioridade',
            'mediaPorTipo',
            'criticosSemCalibracao'
        ));
    }

    /**
     * Relatório de certificados
     */
    public function certificados(Request $request)
    {
        $query = Certificate::with(['calibracao.equipamento']);

        if ($request->has('status')) {
            if ($request->status === 'vencidos') {
                $query->where('data_validade', '<', now());
            } elseif ($request->status === 'vencendo') {
                $query->whereBetween('data_validade', [now(), now()->addDays(30)]);
            } elseif ($request->status === 'validos') {
                $query->where('data_validade', '>=', now());
            }
        }

        $certificates = $query->orderBy('data_validade')->get();

        if ($request->get('format') === 'pdf') {
            $pdf = Pdf::loadView('reports.certificados-pdf', compact('certificates'));
            return $pdf->download('relatorio-certificados.pdf');
        }

        return view('reports.certificados', compact('certificates'));
    }
}

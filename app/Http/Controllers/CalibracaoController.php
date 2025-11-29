<?php

namespace App\Http\Controllers;

use App\Models\Calibracao;
use App\Models\Equipamento;
use App\Http\Requests\StoreCalibracaoRequest;
use App\Http\Requests\UpdateCalibracaoRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\CalibracoesExport;

class CalibracaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $calibracoes = Calibracao::with(['equipamento'])
            ->orderBy('data_calibracao', 'desc')
            ->paginate(20);
        $resultado = $request->get('resultado');
        $from = $request->get('from');
        $to = $request->get('to');

        $calibracoes = Calibracao::with(['equipamento'])
            ->when($resultado, function ($q) use ($resultado) {
                $q->where('resultado', $resultado);
            })
            ->when($from, function ($q) use ($from) {
                $q->whereDate('data_calibracao', '>=', $from);
            })
            ->when($to, function ($q) use ($to) {
                $q->whereDate('data_calibracao', '<=', $to);
            })
            ->orderBy('data_calibracao', 'desc')
            ->paginate(20)
            ->appends($request->query());
        return view('calibracoes.index', compact('calibracoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipamentos = Equipamento::orderBy('codigo_interno')->get();
        return view('calibracoes.create', compact('equipamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalibracaoRequest $request)
    {
        $validated = $request->validated();

        // Upload de certificado
        if ($request->hasFile('arquivo_certificado')) {
            $validated['arquivo_certificado'] = $request->file('arquivo_certificado')->store('certificados', 'public');
        }

        Calibracao::create($validated);

        return redirect()->route('calibracoes.index')
            ->with('success', 'Calibração registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Calibracao $calibracao)
    {
        $calibracao->load(['equipamento', 'parametrosMetrologicos']);
        return view('calibracoes.show', compact('calibracao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calibracao $calibracao)
    {
        $equipamentos = Equipamento::orderBy('codigo_interno')->get();
        return view('calibracoes.edit', compact('calibracao', 'equipamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalibracaoRequest $request, Calibracao $calibracao)
    {
        $validated = $request->validated();

        // Upload de novo certificado
        if ($request->hasFile('arquivo_certificado')) {
            // Deletar certificado antigo se existir
            if ($calibracao->arquivo_certificado && \Storage::disk('public')->exists($calibracao->arquivo_certificado)) {
                \Storage::disk('public')->delete($calibracao->arquivo_certificado);
            }
            $validated['arquivo_certificado'] = $request->file('arquivo_certificado')->store('certificados', 'public');
        }

        $calibracao->update($validated);

        return redirect()->route('calibracoes.index')
            ->with('success', 'Calibração atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calibracao $calibracao)
    {
        $calibracao->delete();

        return redirect()->route('calibracoes.index')
            ->with('success', 'Calibração excluída com sucesso!');
    }

    /**
     * Download certificado de calibração em PDF.
     */
    public function downloadCertificado(Calibracao $calibracao)
    {
        $calibracao->load(['equipamento', 'laboratorio', 'parametros']);

        $pdf = Pdf::loadView('pdf.certificado', compact('calibracao'));

        $filename = 'certificado_' . str_pad($calibracao->id, 8, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export calibrações para Excel.
     */
    public function export(Request $request)
    {
        $filters = [
            'equipamento_id' => $request->get('equipamento_id'),
            'laboratorio_id' => $request->get('laboratorio_id'),
            'data_inicio' => $request->get('from'),
            'data_fim' => $request->get('to'),
            'resultado' => $request->get('resultado'),
        ];

        $export = new CalibracoesExport();
        return $export->download($filters);
    }
}

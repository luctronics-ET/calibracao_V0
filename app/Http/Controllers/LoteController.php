<?php

namespace App\Http\Controllers;

use App\Models\LoteEnvio;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLoteRequest;
use App\Http\Requests\UpdateLoteRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LotesExport;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $from = $request->get('from');
        $to = $request->get('to');
        $laboratorioId = $request->get('laboratorio_id');

        $lotes = LoteEnvio::with(['laboratorio'])
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($laboratorioId, function ($q) use ($laboratorioId) {
                $q->where('laboratorio_id', $laboratorioId);
            })
            ->when($from, function ($q) use ($from) {
                $q->whereDate('data_envio', '>=', $from);
            })
            ->when($to, function ($q) use ($to) {
                $q->whereDate('data_envio', '<=', $to);
            })
            ->orderBy('data_envio', 'desc')
            ->paginate(20)
            ->appends($request->query());

        $laboratorios = Laboratorio::orderBy('nome')->get();
        return view('lotes.index', compact('lotes', 'laboratorios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laboratorios = Laboratorio::orderBy('nome')->get();
        return view('lotes.create', compact('laboratorios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoteRequest $request)
    {
        $validated = $request->validated();

        LoteEnvio::create($validated);

        return redirect()->route('lotes.index')
            ->with('success', 'Lote criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoteEnvio $lote)
    {
        $lote->load(['laboratorio', 'contrato', 'itens.equipamento']);
        return view('lotes.show', compact('lote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoteEnvio $lote)
    {
        $laboratorios = Laboratorio::orderBy('nome')->get();
        return view('lotes.edit', compact('lote', 'laboratorios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoteRequest $request, LoteEnvio $lote)
    {
        $validated = $request->validated();

        $lote->update($validated);

        return redirect()->route('lotes.index')
            ->with('success', 'Lote atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoteEnvio $lote)
    {
        $lote->delete();

        return redirect()->route('lotes.index')
            ->with('success', 'Lote excluído com sucesso!');
    }

    /**
     * Download PDF do lote de envio.
     */
    public function downloadPdf(LoteEnvio $lote)
    {
        $lote->load(['laboratorio', 'equipamentos']);

        $pdf = Pdf::loadView('pdf.lote', compact('lote'));

        $filename = 'lote_' . $lote->numero_lote . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export lotes para Excel.
     */
    public function export(Request $request)
    {
        $filters = [
            'numero_lote' => $request->get('numero_lote'),
            'laboratorio_id' => $request->get('laboratorio_id'),
            'data_inicio' => $request->get('from'),
            'data_fim' => $request->get('to'),
            'status' => $request->get('status'),
        ];

        $export = new LotesExport();
        return $export->download($filters);
    }
}

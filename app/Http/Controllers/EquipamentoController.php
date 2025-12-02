<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Http\Requests\StoreEquipamentoRequest;
use App\Http\Requests\UpdateEquipamentoRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EquipamentosExport;

class EquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $criticidade = $request->get('criticidade');

        $equipamentos = Equipamento::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qbuilder) use ($q) {
                    $qbuilder->where('equipamento_codigo_interno', 'like', "%$q%")
                        ->orWhere('equipamento_tipo', 'like', "%$q%")
                        ->orWhere('equipamento_fabricante', 'like', "%$q%")
                        ->orWhere('equipamento_modelo', 'like', "%$q%")
                        ->orWhere('equipamento_serial', 'like', "%$q%");
                });
            })
            ->when($criticidade, function ($query) use ($criticidade) {
                $query->where('equipamento_classificacao', $criticidade);
            })
            ->orderBy('equipamento_codigo_interno')
            ->get();

        return view('equipamentos.index', compact('equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('equipamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipamentoRequest $request)
    {
        $validated = $request->validated();

        // Upload de foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('equipamentos', 'public');
        }

        Equipamento::create($validated);

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipamento $equipamento)
    {
        $equipamento->load(['calibracoes', 'loteItens.loteEnvio']);
        return view('equipamentos.show', compact('equipamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipamento $equipamento)
    {
        return view('equipamentos.edit', compact('equipamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipamentoRequest $request, Equipamento $equipamento)
    {
        $validated = $request->validated();

        // Upload de nova foto
        if ($request->hasFile('foto')) {
            // Deletar foto antiga se existir
            if ($equipamento->foto && \Storage::disk('public')->exists($equipamento->foto)) {
                \Storage::disk('public')->delete($equipamento->foto);
            }
            $validated['foto'] = $request->file('foto')->store('equipamentos', 'public');
        }

        $equipamento->update($validated);

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();

        return redirect()->route('equipamentos.index')
            ->with('success', 'Equipamento excluído com sucesso!');
    }

    /**
     * Download histórico de calibrações do equipamento em PDF.
     */
    public function downloadHistorico(Equipamento $equipamento)
    {
        $equipamento->load(['calibracoes.laboratorio', 'calibracoes.parametros']);

        $pdf = Pdf::loadView('pdf.historico', compact('equipamento'));

        $filename = 'historico_' . $equipamento->numero_serie . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export equipamentos para Excel.
     */
    public function export(Request $request)
    {
        $filters = [
            'numero_patrimonio' => $request->get('numero_patrimonio'),
            'descricao' => $request->get('descricao'),
            'status' => $request->get('status'),
            'status_calibracao' => $request->get('status_calibracao'),
        ];

        $export = new EquipamentosExport();
        return $export->download($filters);
    }
}

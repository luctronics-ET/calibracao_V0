<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Laboratorio;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $contratos = Contrato::query()
            ->with('laboratorio')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('numero_contrato', 'like', "%$q%")
                        ->orWhere('descricao', 'like', "%$q%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->query());
        return view('contratos.index', compact('contratos'));
    }

    public function create()
    {
        $laboratorios = Laboratorio::orderBy('nome')->get();
        return view('contratos.create', compact('laboratorios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'laboratorio_id' => 'nullable|exists:laboratorios,id',
            'numero_contrato' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'valor_contrato' => 'nullable|numeric',
            'observacoes' => 'nullable|string',
        ]);

        Contrato::create($validated);

        return redirect()->route('contratos.index')
            ->with('success', 'Contrato criado com sucesso!');
    }

    public function show(Contrato $contrato)
    {
        $contrato->load('laboratorio');
        return view('contratos.show', compact('contrato'));
    }

    public function edit(Contrato $contrato)
    {
        $laboratorios = Laboratorio::orderBy('nome')->get();
        return view('contratos.edit', compact('contrato', 'laboratorios'));
    }

    public function update(Request $request, Contrato $contrato)
    {
        $validated = $request->validate([
            'laboratorio_id' => 'nullable|exists:laboratorios,id',
            'numero_contrato' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date',
            'valor_contrato' => 'nullable|numeric',
            'observacoes' => 'nullable|string',
        ]);

        $contrato->update($validated);

        return redirect()->route('contratos.index')
            ->with('success', 'Contrato atualizado com sucesso!');
    }

    public function destroy(Contrato $contrato)
    {
        $contrato->delete();

        return redirect()->route('contratos.index')
            ->with('success', 'Contrato excluído com sucesso!');
    }
}

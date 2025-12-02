<?php

namespace App\Http\Controllers;

use App\Models\Transporte;
use Illuminate\Http\Request;

class TransporteController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $transportes = Transporte::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('transportadora', 'like', "%$q%")
                        ->orWhere('motorista', 'like', "%$q%")
                        ->orWhere('veiculo', 'like', "%$q%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->query());
        return view('transportes.index', compact('transportes'));
    }

    public function create()
    {
        return view('transportes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transportadora' => 'required|string|max:255',
            'motorista' => 'nullable|string|max:255',
            'documento_transporte' => 'nullable|string|max:255',
            'veiculo' => 'nullable|string|max:255',
            'contato' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        Transporte::create($validated);

        return redirect()->route('transportes.index')
            ->with('success', 'Transporte criado com sucesso!');
    }

    public function show(Transporte $transporte)
    {
        return view('transportes.show', compact('transporte'));
    }

    public function edit(Transporte $transporte)
    {
        return view('transportes.edit', compact('transporte'));
    }

    public function update(Request $request, Transporte $transporte)
    {
        $validated = $request->validate([
            'transportadora' => 'required|string|max:255',
            'motorista' => 'nullable|string|max:255',
            'documento_transporte' => 'nullable|string|max:255',
            'veiculo' => 'nullable|string|max:255',
            'contato' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        $transporte->update($validated);

        return redirect()->route('transportes.index')
            ->with('success', 'Transporte atualizado com sucesso!');
    }

    public function destroy(Transporte $transporte)
    {
        $transporte->delete();

        return redirect()->route('transportes.index')
            ->with('success', 'Transporte excluído com sucesso!');
    }
}

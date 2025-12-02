<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $locais = Local::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('nome', 'like', "%$q%")
                        ->orWhere('tipo', 'like', "%$q%")
                        ->orWhere('referencia', 'like', "%$q%");
                });
            })
            ->orderBy('nome')
            ->paginate(20)
            ->appends($request->query());
        return view('locais.index', compact('locais'));
    }

    public function create()
    {
        return view('locais.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
        ]);

        Local::create($validated);

        return redirect()->route('locais.index')
            ->with('success', 'Local criado com sucesso!');
    }

    public function show(Local $local)
    {
        return view('locais.show', compact('local'));
    }

    public function edit(Local $local)
    {
        return view('locais.edit', compact('local'));
    }

    public function update(Request $request, Local $local)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
        ]);

        $local->update($validated);

        return redirect()->route('locais.index')
            ->with('success', 'Local atualizado com sucesso!');
    }

    public function destroy(Local $local)
    {
        $local->delete();

        return redirect()->route('locais.index')
            ->with('success', 'Local excluído com sucesso!');
    }
}

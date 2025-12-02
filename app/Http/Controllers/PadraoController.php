<?php

namespace App\Http\Controllers;

use App\Models\Padrao;
use Illuminate\Http\Request;

class PadraoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $padroes = Padrao::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('nome', 'like', "%$q%")
                        ->orWhere('modelo', 'like', "%$q%")
                        ->orWhere('fabricante', 'like', "%$q%")
                        ->orWhere('numero_serie', 'like', "%$q%");
                });
            })
            ->orderBy('nome')
            ->paginate(20)
            ->appends($request->query());
        return view('padroes.index', compact('padroes'));
    }

    public function create()
    {
        return view('padroes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'rbc_codigo_laboratorio' => 'nullable|string|max:255',
            'validade_certificado' => 'nullable|date',
            'arquivo_certificado_pdf' => 'nullable|string',
            'arquivo_sha256' => 'nullable|string',
        ]);

        Padrao::create($validated);

        return redirect()->route('padroes.index')
            ->with('success', 'Padrão criado com sucesso!');
    }

    public function show(Padrao $padrao)
    {
        return view('padroes.show', compact('padrao'));
    }

    public function edit(Padrao $padrao)
    {
        return view('padroes.edit', compact('padrao'));
    }

    public function update(Request $request, Padrao $padrao)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'rbc_codigo_laboratorio' => 'nullable|string|max:255',
            'validade_certificado' => 'nullable|date',
            'arquivo_certificado_pdf' => 'nullable|string',
            'arquivo_sha256' => 'nullable|string',
        ]);

        $padrao->update($validated);

        return redirect()->route('padroes.index')
            ->with('success', 'Padrão atualizado com sucesso!');
    }

    public function destroy(Padrao $padrao)
    {
        $padrao->delete();

        return redirect()->route('padroes.index')
            ->with('success', 'Padrão excluído com sucesso!');
    }
}

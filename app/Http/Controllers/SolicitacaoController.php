<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use Illuminate\Http\Request;

class SolicitacaoController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $solicitacoes = Solicitacao::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('solicitante', 'like', "%$q%")
                        ->orWhere('tipo_servico', 'like', "%$q%")
                        ->orWhere('descricao', 'like', "%$q%");
                });
            })
            ->orderBy('data_solicitacao', 'desc')
            ->paginate(20)
            ->appends($request->query());
        return view('solicitacoes.index', compact('solicitacoes'));
    }

    public function create()
    {
        return view('solicitacoes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'solicitante' => 'required|string|max:255',
            'tipo_servico' => 'nullable|string|max:255',
            'data_solicitacao' => 'nullable|date',
            'descricao' => 'nullable|string',
            'status' => 'nullable|string|max:50',
        ]);

        Solicitacao::create($validated);

        return redirect()->route('solicitacoes.index')
            ->with('success', 'Solicitação criada com sucesso!');
    }

    public function show(Solicitacao $solicitacao)
    {
        return view('solicitacoes.show', compact('solicitacao'));
    }

    public function edit(Solicitacao $solicitacao)
    {
        return view('solicitacoes.edit', compact('solicitacao'));
    }

    public function update(Request $request, Solicitacao $solicitacao)
    {
        $validated = $request->validate([
            'solicitante' => 'required|string|max:255',
            'tipo_servico' => 'nullable|string|max:255',
            'data_solicitacao' => 'nullable|date',
            'descricao' => 'nullable|string',
            'status' => 'nullable|string|max:50',
        ]);

        $solicitacao->update($validated);

        return redirect()->route('solicitacoes.index')
            ->with('success', 'Solicitação atualizada com sucesso!');
    }

    public function destroy(Solicitacao $solicitacao)
    {
        $solicitacao->delete();

        return redirect()->route('solicitacoes.index')
            ->with('success', 'Solicitação excluída com sucesso!');
    }
}

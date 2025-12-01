<?php

namespace App\Http\Controllers;

use App\Models\Calibracao;
use Illuminate\Http\Request;

class CalibracaoController extends Controller
{
    public function index()
    {
        $calibracoes = Calibracao::with(['equipamento', 'laboratorio'])->paginate(20);
        return view('calibracoes.index', compact('calibracoes'));
    }

    public function create()
    {
        return view('calibracoes.create');
    }

    public function store(Request $request)
    {
        $calibracao = Calibracao::create($request->all());
        return redirect()->route('calibracoes.index');
    }

    public function show(Calibracao $calibracao)
    {
        return view('calibracoes.show', compact('calibracao'));
    }

    public function edit(Calibracao $calibracao)
    {
        return view('calibracoes.edit', compact('calibracao'));
    }

    public function update(Request $request, Calibracao $calibracao)
    {
        $calibracao->update($request->all());
        return redirect()->route('calibracoes.index');
    }

    public function destroy(Calibracao $calibracao)
    {
        $calibracao->delete();
        return redirect()->route('calibracoes.index');
    }

    public function export()
    {
        // Implementar exportação
        return response()->json(['message' => 'Exportação em desenvolvimento']);
    }

    public function downloadCertificado(Calibracao $calibracao)
    {
        // Implementar download de certificado
        return response()->json(['message' => 'Download em desenvolvimento']);
    }
}

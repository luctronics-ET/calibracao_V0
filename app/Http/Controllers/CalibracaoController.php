<?php

namespace App\Http\Controllers;

use App\Models\Calibracao;
use App\Models\Equipamento;
use App\Models\Laboratorio;
use Illuminate\Http\Request;

class CalibracaoController extends Controller
{
    public function index()
    {
        $calibracoes = Calibracao::with(['equipamento', 'laboratorio'])->get();
        return view('calibracoes.index', compact('calibracoes'));
    }

    public function create()
    {
        $equipamentos = Equipamento::all();
        $laboratorios = Laboratorio::all();
        return view('calibracoes.create', compact('equipamentos', 'laboratorios'));
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
        $equipamentos = Equipamento::all();
        $laboratorios = Laboratorio::all();
        return view('calibracoes.edit', compact('calibracao', 'equipamentos', 'laboratorios'));
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

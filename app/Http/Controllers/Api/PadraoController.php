<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Padrao;
use Illuminate\Http\Request;

class PadraoController extends Controller {
    public function index() {
        return response()->json(Padrao::all());
    }

    public function show($id) {
        return response()->json(Padrao::findOrFail($id));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'rbc_codigo_laboratorio' => 'nullable|string|max:100',
            'validade_certificado' => 'nullable|date'
        ]);

        $padrao = Padrao::create($validated);
        return response()->json($padrao, 201);
    }

    public function update(Request $request, $id) {
        $padrao = Padrao::findOrFail($id);
        $padrao->update($request->all());
        return response()->json($padrao);
    }

    public function destroy($id) {
        $padrao = Padrao::findOrFail($id);
        $padrao->delete();
        return response()->json(['message' => 'Padrão excluído com sucesso']);
    }
}

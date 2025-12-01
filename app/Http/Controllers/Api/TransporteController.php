<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transporte;
use Illuminate\Http\Request;

class TransporteController extends Controller {
    public function index() {
        return response()->json(Transporte::all());
    }

    public function show($id) {
        return response()->json(Transporte::findOrFail($id));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'transportadora' => 'required|string|max:255',
            'motorista' => 'nullable|string|max:255',
            'documento_transporte' => 'nullable|string|max:255',
            'veiculo' => 'nullable|string|max:255',
            'contato' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string'
        ]);

        $transporte = Transporte::create($validated);
        return response()->json($transporte, 201);
    }

    public function update(Request $request, $id) {
        $transporte = Transporte::findOrFail($id);
        $transporte->update($request->all());
        return response()->json($transporte);
    }

    public function destroy($id) {
        $transporte = Transporte::findOrFail($id);
        $transporte->delete();
        return response()->json(['message' => 'Transporte excluído com sucesso']);
    }
}

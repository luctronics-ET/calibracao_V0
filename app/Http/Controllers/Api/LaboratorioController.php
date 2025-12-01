<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laboratorio;
use Illuminate\Http\Request;

class LaboratorioController extends Controller {
    public function index() {
        return response()->json(Laboratorio::all());
    }

    public function show($id) {
        return response()->json(Laboratorio::with(['calibracoes', 'lotes'])->findOrFail($id));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'rbc_codigo' => 'nullable|string|max:50',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
            'acreditacao' => 'nullable|string'
        ]);

        $laboratorio = Laboratorio::create($validated);
        return response()->json($laboratorio, 201);
    }

    public function update(Request $request, $id) {
        $laboratorio = Laboratorio::findOrFail($id);
        
        $validated = $request->validate([
            'nome' => 'string|max:255',
            'rbc_codigo' => 'nullable|string|max:50',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string',
            'acreditacao' => 'nullable|string'
        ]);

        $laboratorio->update($validated);
        return response()->json($laboratorio);
    }

    public function destroy($id) {
        $laboratorio = Laboratorio::findOrFail($id);
        
        if ($laboratorio->calibracoes()->count() > 0) {
            return response()->json(['message' => 'Laboratório possui calibrações vinculadas'], 409);
        }
        
        $laboratorio->delete();
        return response()->json(['message' => 'Laboratório excluído com sucesso']);
    }
}

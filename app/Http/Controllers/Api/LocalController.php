<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller {
    public function index() {
        return response()->json(Local::all());
    }

    public function show($id) {
        return response()->json(Local::findOrFail($id));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:100',
            'referencia' => 'nullable|string|max:100',
            'descricao' => 'nullable|string',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string'
        ]);

        $local = Local::create($validated);
        return response()->json($local, 201);
    }

    public function update(Request $request, $id) {
        $local = Local::findOrFail($id);
        
        $validated = $request->validate([
            'nome' => 'string|max:255',
            'tipo' => 'nullable|string|max:100',
            'referencia' => 'nullable|string|max:100',
            'descricao' => 'nullable|string',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string'
        ]);

        $local->update($validated);
        return response()->json($local);
    }

    public function destroy($id) {
        $local = Local::findOrFail($id);
        $local->delete();
        return response()->json(['message' => 'Local excluído com sucesso']);
    }
}

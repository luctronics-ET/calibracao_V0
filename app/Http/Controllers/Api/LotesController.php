<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use Illuminate\Http\Request;

class LotesController extends Controller {
    public function index() {
        return response()->json(
            Lote::with(['contratoServico', 'laboratorio', 'transporte', 'equipamentos'])->orderBy('id', 'desc')->paginate(20)
        );
    }

    public function show($id) {
        return response()->json(
            Lote::with(['contratoServico', 'laboratorio', 'transporte', 'equipamentos'])->findOrFail($id)
        );
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'contrato_servico_id' => 'nullable|exists:contratos_servico,id',
            'laboratorio_id' => 'required|exists:laboratorios,id',
            'transporte_id' => 'nullable|exists:transportes,id',
            'descricao' => 'required|string',
            'data_envio_lote' => 'nullable|date',
            'data_recebimento_laboratorio' => 'nullable|date',
            'data_retorno_prevista' => 'nullable|date',
            'data_retorno_recebida' => 'nullable|date',
            'observacoes' => 'nullable|string'
        ]);

        $lote = Lote::create($validated);

        if ($request->has('equipamento_ids')) {
            $lote->equipamentos()->attach($request->equipamento_ids);
        }

        return response()->json($lote->load('equipamentos', 'laboratorio'), 201);
    }

    public function update(Request $request, $id) {
        $lote = Lote::findOrFail($id);
        
        $validated = $request->validate([
            'contrato_servico_id' => 'nullable|exists:contratos_servico,id',
            'laboratorio_id' => 'exists:laboratorios,id',
            'transporte_id' => 'nullable|exists:transportes,id',
            'descricao' => 'string',
            'data_envio_lote' => 'nullable|date',
            'data_recebimento_laboratorio' => 'nullable|date',
            'data_retorno_prevista' => 'nullable|date',
            'data_retorno_recebida' => 'nullable|date',
            'observacoes' => 'nullable|string'
        ]);

        $lote->update($validated);

        if ($request->has('equipamento_ids')) {
            $lote->equipamentos()->sync($request->equipamento_ids);
        }

        return response()->json($lote->fresh()->load('equipamentos', 'laboratorio'));
    }

    public function destroy($id) {
        $lote = Lote::findOrFail($id);
        $lote->equipamentos()->detach();
        $lote->delete();
        return response()->json(['message' => 'Lote excluído com sucesso']);
    }
}

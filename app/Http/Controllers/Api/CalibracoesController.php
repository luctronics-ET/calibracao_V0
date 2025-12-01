<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calibracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CalibracoesController extends Controller {
    public function index(Request $request) {
        $query = Calibracao::with(['equipamento', 'laboratorio', 'lote']);

        if ($request->has('equipamento_id')) {
            $query->where('equipamento_id', $request->equipamento_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->orderBy('data_calibracao', 'desc')->paginate(20));
    }

    public function show($id) {
        return response()->json(
            Calibracao::with(['equipamento', 'laboratorio', 'lote', 'contratoServico'])->findOrFail($id)
        );
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'equipamento_id' => 'required|exists:equipamentos,id',
            'data_calibracao' => 'required|date',
            'laboratorio_id' => 'required|exists:laboratorios,id',
            'rbc_codigo_laboratorio' => 'nullable|string|max:100',
            'rbc_metodo_calibracao' => 'nullable|string',
            'rbc_incerteza_prevista' => 'nullable|string|max:255',
            'rbc_capacidade_medicao' => 'nullable|string|max:255',
            'conformidade_ilac_p14' => 'nullable|boolean',
            'status' => 'nullable|string|max:50',
            'lote_id' => 'nullable|exists:lotes,id',
            'contrato_servico_id' => 'nullable|exists:contratos_servico,id',
            'proxima_calibracao_sugerida' => 'nullable|date',
            'observacoes' => 'nullable|string'
        ]);

        $calibracao = Calibracao::create($validated);
        return response()->json($calibracao->load('equipamento', 'laboratorio'), 201);
    }

    public function update(Request $request, $id) {
        $calibracao = Calibracao::findOrFail($id);
        
        $validated = $request->validate([
            'data_calibracao' => 'date',
            'laboratorio_id' => 'exists:laboratorios,id',
            'rbc_codigo_laboratorio' => 'nullable|string|max:100',
            'rbc_metodo_calibracao' => 'nullable|string',
            'rbc_incerteza_prevista' => 'nullable|string|max:255',
            'rbc_capacidade_medicao' => 'nullable|string|max:255',
            'conformidade_ilac_p14' => 'nullable|boolean',
            'status' => 'nullable|string|max:50',
            'proxima_calibracao_sugerida' => 'nullable|date',
            'observacoes' => 'nullable|string'
        ]);

        $calibracao->update($validated);
        return response()->json($calibracao->fresh()->load('equipamento', 'laboratorio'));
    }

    public function destroy($id) {
        $calibracao = Calibracao::findOrFail($id);
        
        if ($calibracao->arquivo_certificado_pdf) {
            Storage::delete($calibracao->arquivo_certificado_pdf);
        }
        
        $calibracao->delete();
        return response()->json(['message' => 'Calibração excluída com sucesso']);
    }

    public function uploadCertificado(Request $request, $id) {
        $calibracao = Calibracao::findOrFail($id);

        $request->validate(['certificado' => 'required|file|mimes:pdf|max:10240']);

        if ($calibracao->arquivo_certificado_pdf) {
            Storage::delete($calibracao->arquivo_certificado_pdf);
        }

        $path = $request->file('certificado')->store('certificados', 'public');
        $hash = hash_file('sha256', $request->file('certificado')->getRealPath());

        $calibracao->update([
            'arquivo_certificado_pdf' => $path,
            'arquivo_sha256' => $hash
        ]);

        return response()->json(['message' => 'Certificado enviado com sucesso', 'path' => Storage::url($path)]);
    }
}

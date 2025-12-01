<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipamento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EquipamentoController extends Controller
{
    /**
     * Lista equipamentos com filtros, busca e paginação
     * 
     * Query params:
     * - search: busca por tipo, modelo, fabricante, código
     * - classe: filtro por classe (ELE, MEC, DIM)
     * - status: filtro por status (ativo, fora_uso, condenado, reserva)
     * - classificacao: filtro por classificação IGP (baixa, media, alta)
     * - per_page: itens por página (padrão: 20)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Equipamento::query()->with(['calibracoes' => function ($q) {
            $q->latest()->take(1);
        }]);

        // Filtro de busca textual
        if ($request->has('search')) {
            $query->buscar($request->search);
        }

        // Filtro por classe
        if ($request->has('classe')) {
            $query->where('classe', $request->classe);
        }

        // Filtro por status
        if ($request->has('status')) {
            $query->porStatus($request->status);
        }

        // Filtro por classificação IGP
        if ($request->has('classificacao')) {
            $query->porClassificacao($request->classificacao);
        }

        // Filtro por setor
        if ($request->has('setor')) {
            $query->where('setor', $request->setor);
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $perPage = min($request->get('per_page', 20), 100);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Exibe um equipamento específico com todos os relacionamentos
     */
    public function show($id): JsonResponse
    {
        $equipamento = Equipamento::with([
            'calibracoes' => function ($q) {
                $q->latest();
            },
            'parametros',
            'loteItens.lote'
        ])->findOrFail($id);

        return response()->json($equipamento);
    }

    /**
     * Cria um novo equipamento
     */
    public function store(Request $request): JsonResponse
    {
        $validator = $this->validateEquipamento($request);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Upload de arquivos
        $data = $this->handleFileUploads($request, $data);

        // Criar equipamento (IGP será calculado automaticamente no observer)
        $equipamento = Equipamento::create($data);

        return response()->json([
            'message' => 'Equipamento criado com sucesso',
            'data' => $equipamento->load('calibracoes')
        ], 201);
    }

    /**
     * Atualiza um equipamento existente
     */
    public function update(Request $request, $id): JsonResponse
    {
        $equipamento = Equipamento::findOrFail($id);

        $validator = $this->validateEquipamento($request, $id);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Upload de arquivos
        $data = $this->handleFileUploads($request, $data, $equipamento);

        // Atualizar equipamento (IGP será recalculado automaticamente se necessário)
        $equipamento->update($data);

        return response()->json([
            'message' => 'Equipamento atualizado com sucesso',
            'data' => $equipamento->fresh()->load('calibracoes')
        ]);
    }

    /**
     * Remove um equipamento
     */
    public function destroy($id): JsonResponse
    {
        $equipamento = Equipamento::findOrFail($id);

        // Verificar se tem calibrações
        if ($equipamento->calibracoes()->count() > 0) {
            return response()->json([
                'message' => 'Não é possível excluir equipamento com calibrações registradas'
            ], 409);
        }

        // Remover arquivos
        $this->deleteFiles($equipamento);

        $equipamento->delete();

        return response()->json([
            'message' => 'Equipamento excluído com sucesso'
        ]);
    }

    /**
     * Recalcula o IGP manualmente (endpoint adicional)
     */
    public function recalcularIGP($id): JsonResponse
    {
        $equipamento = Equipamento::findOrFail($id);
        $equipamento->calcularIGP();
        $equipamento->save();

        return response()->json([
            'message' => 'IGP recalculado com sucesso',
            'data' => [
                'igp' => $equipamento->igp,
                'classificacao' => $equipamento->classificacao_igp,
                'cor' => $equipamento->cor_classificacao,
            ]
        ]);
    }

    /**
     * Upload de foto do equipamento
     */
    public function uploadFoto(Request $request, $id): JsonResponse
    {
        $equipamento = Equipamento::findOrFail($id);

        $request->validate([
            'foto' => 'required|image|max:5120', // 5MB
        ]);

        if ($equipamento->foto) {
            Storage::disk('public')->delete($equipamento->foto);
        }

        $path = $request->file('foto')->store('equipamentos/fotos', 'public');

        $equipamento->update(['foto' => $path]);

        return response()->json([
            'message' => 'Foto enviada com sucesso',
            'path' => Storage::url($path)
        ]);
    }

    /**
     * Upload de PDF (manual, certificado)
     */
    public function uploadPdf(Request $request, $id): JsonResponse
    {
        $equipamento = Equipamento::findOrFail($id);

        $request->validate([
            'tipo' => 'required|in:manual,certificado',
            'arquivo' => 'required|file|mimes:pdf|max:10240', // 10MB
        ]);

        $tipo = $request->tipo;
        $campo = $tipo === 'manual' ? 'manual_pdf' : 'certificado_pdf';

        if ($equipamento->$campo) {
            Storage::disk('public')->delete($equipamento->$campo);
        }

        $path = $request->file('arquivo')->store("equipamentos/{$tipo}s", 'public');

        $equipamento->update([$campo => $path]);

        return response()->json([
            'message' => ucfirst($tipo) . ' enviado com sucesso',
            'path' => Storage::url($path)
        ]);
    }

    /**
     * Validação dos dados do equipamento
     */
    private function validateEquipamento(Request $request, $id = null)
    {
        return Validator::make($request->all(), [
            // Campos obrigatórios
            'tipo' => 'required|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',

            // Identificação
            'classe' => 'nullable|in:ELE,MEC,DIM',
            'serie' => 'nullable|string|max:255',
            'codigo_interno' => 'nullable|string|max:255|unique:equipamentos,codigo_interno,' . $id,
            'patrimonio' => 'nullable|string|max:255',

            // Dimensões (mm, V, W)
            'altura_mm' => 'nullable|integer|min:0',
            'largura_mm' => 'nullable|integer|min:0',
            'comprimento_mm' => 'nullable|integer|min:0',
            'tensao_v' => 'nullable|integer|min:0',
            'potencia_w' => 'nullable|integer|min:0',

            // Metrologia
            'faixa_medicao' => 'nullable|string|max:255',
            'resolucao' => 'nullable|string|max:255',
            'incerteza_nominal' => 'nullable|string|max:255',
            'periodicidade_meses' => 'nullable|integer|min:1|max:60',

            // Status e localização
            'status' => 'nullable|in:ativo,fora_uso,condenado,reserva',
            'localizacao' => 'nullable|string|max:255',
            'setor' => 'nullable|string|max:255',

            // Documentação
            'link_fabricante' => 'nullable|url',
            'instrucao_uso' => 'nullable|string',
            'instrucao_operacao' => 'nullable|string',
            'instrucao_seguranca' => 'nullable|string',
            'comentarios' => 'nullable|string',

            // Financeiro
            'valor_aquisicao' => 'nullable|numeric|min:0',
            'data_aquisicao' => 'nullable|date',
            'custo_estimado' => 'nullable|numeric|min:0',

            // Certificação
            'certificado_status' => 'nullable|in:valido,vencido,pendente',
            'local_calibracao' => 'nullable|string|max:255',

            // Matriz IGP (1-3)
            'frequencia_uso' => 'nullable|integer|min:1|max:3',
            'necessidade_critica' => 'nullable|integer|min:1|max:3',
            'abundancia' => 'nullable|integer|min:1|max:3',
            'custo_indisponibilidade' => 'nullable|integer|min:1|max:3',
            'criticidade_metrologica' => 'nullable|integer|min:1|max:3',
        ]);
    }

    /**
     * Processa upload de arquivos (base64 ou multipart)
     */
    private function handleFileUploads(Request $request, array $data, $equipamento = null): array
    {
        // Upload de foto (base64)
        if ($request->has('foto_base64')) {
            if ($equipamento && $equipamento->foto) {
                Storage::disk('public')->delete($equipamento->foto);
            }

            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->foto_base64));
            $filename = 'equipamento_' . time() . '.jpg';
            $path = "equipamentos/fotos/{$filename}";

            Storage::disk('public')->put($path, $image);
            $data['foto'] = $path;
        }

        // Upload de manual PDF (base64)
        if ($request->has('manual_pdf_base64')) {
            if ($equipamento && $equipamento->manual_pdf) {
                Storage::disk('public')->delete($equipamento->manual_pdf);
            }

            $pdf = base64_decode(preg_replace('#^data:application/pdf;base64,#i', '', $request->manual_pdf_base64));
            $filename = 'manual_' . time() . '.pdf';
            $path = "equipamentos/manuais/{$filename}";

            Storage::disk('public')->put($path, $pdf);
            $data['manual_pdf'] = $path;
        }

        return $data;
    }

    /**
     * Remove arquivos do equipamento
     */
    private function deleteFiles($equipamento): void
    {
        if ($equipamento->foto) {
            Storage::disk('public')->delete($equipamento->foto);
        }

        if ($equipamento->manual_pdf) {
            Storage::disk('public')->delete($equipamento->manual_pdf);
        }

        if ($equipamento->certificado_pdf) {
            Storage::disk('public')->delete($equipamento->certificado_pdf);
        }
    }
}

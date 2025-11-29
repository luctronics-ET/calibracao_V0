<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'divisao_origem' => 'nullable|string|max:50',
            'tipo' => 'required|string|max:100',
            'categoria' => 'nullable|string|max:50',
            'fabricante' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'serie' => 'nullable|string|max:100',
            'codigo_interno' => 'required|string|max:50|unique:equipamentos,codigo_interno',
            'descricao' => 'nullable|string',
            'local_fisico_atual' => 'nullable|string|max:200',
            'ciclo_meses' => 'nullable|integer|min:1|max:120',
            'criticidade' => 'nullable|in:baixa,media,alta,critica',
            'classe_metrologica' => 'nullable|string|max:50',
            'resolucao' => 'nullable|string|max:50',
            'faixa_medicao' => 'nullable|string|max:100',
            'mpe' => 'nullable|string|max:100',
            'norma_aplicavel' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }
}

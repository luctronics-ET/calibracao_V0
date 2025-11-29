<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalibracaoRequest extends FormRequest
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
            'equipamento_id' => 'required|exists:equipamentos,id',
            'data_calibracao' => 'required|date',
            'data_validade' => 'required|date|after:data_calibracao',
            'certificado_num' => 'nullable|string|max:100',
            'laboratorio_nome' => 'nullable|string|max:200',
            'resultado' => 'nullable|in:aprovado,reprovado,condicional',
            'observacoes' => 'nullable|string',
            'arquivo_certificado' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }
}

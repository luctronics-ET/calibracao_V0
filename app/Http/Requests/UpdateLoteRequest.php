<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoteRequest extends FormRequest
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
            'laboratorio_id' => 'required|exists:laboratorios,id',
            'contrato_id' => 'nullable|exists:contratos,id',
            'data_envio' => 'required|date',
            'data_prev_retorno' => 'nullable|date|after_or_equal:data_envio',
            'data_retorno' => 'nullable|date|after_or_equal:data_envio',
            'status' => 'required|in:preparacao,enviado,em_calibracao,concluido,cancelado',
            'observacoes' => 'nullable|string',
        ];
    }
}

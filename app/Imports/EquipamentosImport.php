<?php

namespace App\Imports;

use App\Models\Equipamento;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EquipamentosImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Equipamento([
            'divisao_origem' => $row['divisao_origem'] ?? null,
            'tipo' => $row['tipo'] ?? null,
            'categoria' => $row['categoria'] ?? null,
            'fabricante' => $row['fabricante'] ?? null,
            'modelo' => $row['modelo'] ?? null,
            'serie' => $row['serie'] ?? null,
            'codigo_interno' => $row['codigo_interno'] ?? null,
            'descricao' => $row['descricao'] ?? null,
            'local_fisico_atual' => $row['local_fisico_atual'] ?? null,
            'ciclo_meses' => $row['ciclo_meses'] ?? 12,
            'criticidade' => $row['criticidade'] ?? 'media',
            'classe_metrologica' => $row['classe_metrologica'] ?? null,
            'resolucao' => $row['resolucao'] ?? null,
            'faixa_medicao' => $row['faixa_medicao'] ?? null,
            'mpe' => $row['mpe'] ?? null,
            'norma_aplicavel' => $row['norma_aplicavel'] ?? null,
        ]);
    }

    /**
     * Regras de validação
     */
    public function rules(): array
    {
        return [
            'tipo' => 'required|string|max:100',
            'codigo_interno' => 'required|string|max:50|unique:equipamentos,codigo_interno',
            'ciclo_meses' => 'nullable|integer|min:1|max:120',
            'criticidade' => 'nullable|in:baixa,media,alta,critica',
        ];
    }

    /**
     * Mensagens de erro customizadas
     */
    public function customValidationMessages()
    {
        return [
            'tipo.required' => 'O campo tipo é obrigatório',
            'codigo_interno.required' => 'O campo código interno é obrigatório',
            'codigo_interno.unique' => 'Este código interno já existe no sistema',
            'ciclo_meses.integer' => 'O ciclo deve ser um número inteiro',
            'criticidade.in' => 'A criticidade deve ser: baixa, media, alta ou critica',
        ];
    }
}

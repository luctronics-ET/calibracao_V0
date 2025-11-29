<?php

namespace Database\Factories;

use App\Models\Equipamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipamentoFactory extends Factory
{
    protected $model = Equipamento::class;

    public function definition(): array
    {
        return [
            'divisao_origem' => $this->faker->randomElement(['Metrologia', 'Produção', 'Qualidade']),
            'tipo' => $this->faker->randomElement(['Medição', 'Teste', 'Inspeção']),
            'categoria' => $this->faker->randomElement(['Dimensional', 'Massa', 'Temperatura', 'Elétrica']),
            'fabricante' => $this->faker->company(),
            'modelo' => 'MOD-' . $this->faker->randomNumber(4),
            'serie' => 'SN' . $this->faker->randomNumber(6),
            'codigo_interno' => 'EQ-' . str_pad($this->faker->unique()->numberBetween(1, 9999), 3, '0', STR_PAD_LEFT),
            'descricao' => $this->faker->sentence(4),
            'local_fisico_atual' => $this->faker->randomElement(['Lab 1', 'Lab 2', 'Almoxarifado', 'Produção']),
            'ciclo_meses' => $this->faker->randomElement([6, 12, 24]),
            'criticidade' => $this->faker->randomElement(['baixa', 'media', 'alta', 'critica']),
            'classe_metrologica' => $this->faker->randomElement(['Classe A', 'Classe B', 'Classe C']),
            'resolucao' => $this->faker->randomElement(['0.01mm', '0.001mm', '0.1°C', '1mV']),
            'faixa_medicao' => $this->faker->randomElement(['0-100mm', '0-500mm', '-50 a 300°C']),
            'mpe' => $this->faker->randomElement(['±0.01mm', '±0.02mm', '±0.5°C', '±1%']),
            'norma_aplicavel' => $this->faker->randomElement(['ISO 9001', 'ISO 17025', 'ABNT NBR']),
            'status_calibracao' => $this->faker->randomElement(['em_dia', 'vencendo', 'vencida']),
        ];
    }
}

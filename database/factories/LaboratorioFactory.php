<?php

namespace Database\Factories;

use App\Models\Laboratorio;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaboratorioFactory extends Factory
{
    protected $model = Laboratorio::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->company() . ' Lab',
            'cnpj' => $this->faker->numerify('##.###.###/####-##'),
            'endereco' => $this->faker->address(),
            'contato' => $this->faker->name(),
            'acreditado' => $this->faker->boolean(),
            'escopo' => $this->faker->randomElement(['Dimensional', 'Eletrico', 'Termico', 'Massa']),
        ];
    }
}

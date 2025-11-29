<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'senha_hash' => Hash::make('password'),
            'permissao' => $this->faker->randomElement(['admin', 'tecnico', 'user']),
            'setor' => $this->faker->randomElement(['Metrologia', 'Qualidade', 'Produção', 'TI']),
        ];
    }

    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'permissao' => 'admin',
        ]);
    }

    public function tecnico()
    {
        return $this->state(fn (array $attributes) => [
            'permissao' => 'tecnico',
        ]);
    }
}

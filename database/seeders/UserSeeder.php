<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nome' => 'Administrador',
            'email' => 'admin@calibracao.com',
            'senha_hash' => Hash::make('admin123'),
            'permissao' => 'admin',
            'setor' => 'TI',
        ]);

        // Técnico
        User::create([
            'nome' => 'Técnico Metrologia',
            'email' => 'tecnico@calibracao.com',
            'senha_hash' => Hash::make('tecnico123'),
            'permissao' => 'tecnico',
            'setor' => 'Metrologia',
        ]);

        // Visualizador
        User::create([
            'nome' => 'Usuário Visualizador',
            'email' => 'visualizador@calibracao.com',
            'senha_hash' => Hash::make('visualizador123'),
            'permissao' => 'user',
            'setor' => 'Produção',
        ]);
    }
}

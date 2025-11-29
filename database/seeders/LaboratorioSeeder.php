<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laboratorio;
use Illuminate\Support\Facades\DB;

class LaboratorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('laboratorios')->delete();

        $laboratorios = [
            [
                'nome' => 'Labcal - Laboratório de Calibração',
                'cnpj' => '12.345.678/0001-90',
                'endereco' => 'Rua das Medições, 100 - São Paulo/SP',
                'contato' => 'contato@labcal.com.br | (11) 3000-1000',
                'acreditado' => true,
                'escopo' => 'Temperatura, Pressão, Tensão, Corrente Elétrica',
            ],
            [
                'nome' => 'Metrolab - Metrologia e Calibração',
                'cnpj' => '98.765.432/0001-10',
                'endereco' => 'Av. da Precisão, 500 - Rio de Janeiro/RJ',
                'contato' => 'calibracao@metrolab.com.br | (21) 2500-2000',
                'acreditado' => true,
                'escopo' => 'Dimensão, Massa, Força',
            ],
            [
                'nome' => 'Calibra+ Serviços Metrológicos',
                'cnpj' => '11.222.333/0001-44',
                'endereco' => 'Rua Exata, 250 - Campinas/SP',
                'contato' => 'atendimento@calibramais.com.br | (19) 3100-3000',
                'acreditado' => true,
                'escopo' => 'Instrumentos Elétricos e Eletrônicos',
            ],
            [
                'nome' => 'Precisão Lab',
                'cnpj' => '55.666.777/0001-88',
                'endereco' => 'Av. Industrial, 800 - Curitiba/PR',
                'contato' => 'lab@precisaolab.com.br | (41) 3200-4000',
                'acreditado' => false,
                'escopo' => 'Calibrações diversas',
            ],
        ];

        foreach ($laboratorios as $lab) {
            Laboratorio::create($lab);
        }

        $this->command->info('Laboratórios criados com sucesso!');
    }
}

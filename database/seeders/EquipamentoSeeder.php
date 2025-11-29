<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;
use Illuminate\Support\Facades\DB;

class EquipamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipamentos')->delete();

        $equipamentos = [
            [
                'divisao_origem' => 'CMASM',
                'tipo' => 'Multímetro',
                'categoria' => 'Elétrico',
                'fabricante' => 'Fluke',
                'modelo' => '87V',
                'serie' => 'FL87V12345',
                'codigo_interno' => 'EQ-001',
                'descricao' => 'Multímetro Digital de Alta Precisão',
                'local_fisico_atual' => 'Laboratório Elétrica',
                'ciclo_meses' => 12,
                'criticidade' => 'Alta',
                'classe_metrologica' => 'Classe 1',
                'resolucao' => '0.01V',
                'faixa_medicao' => '0-1000V',
                'mpe' => '±0.5%',
                'norma_aplicavel' => 'IEC 61010',
            ],
            [
                'divisao_origem' => 'MSMI',
                'tipo' => 'Paquímetro',
                'categoria' => 'Dimensional',
                'fabricante' => 'Mitutoyo',
                'modelo' => 'CD-6" CS',
                'serie' => 'MIT2023456',
                'codigo_interno' => 'EQ-002',
                'descricao' => 'Paquímetro Digital 150mm',
                'local_fisico_atual' => 'Oficina Mecânica',
                'ciclo_meses' => 12,
                'criticidade' => 'Média',
                'classe_metrologica' => 'Classe 2',
                'resolucao' => '0.01mm',
                'faixa_medicao' => '0-150mm',
                'mpe' => '±0.02mm',
                'norma_aplicavel' => 'ABNT NBR 16106',
            ],
            [
                'divisao_origem' => 'CMASM',
                'tipo' => 'Termômetro',
                'categoria' => 'Temperatura',
                'fabricante' => 'Instrutemp',
                'modelo' => 'ITWTHI-150',
                'serie' => 'TEMP789012',
                'codigo_interno' => 'EQ-003',
                'descricao' => 'Termômetro Digital Infravermelho',
                'local_fisico_atual' => 'Laboratório Temperatura',
                'ciclo_meses' => 6,
                'criticidade' => 'Alta',
                'classe_metrologica' => 'Classe 1',
                'resolucao' => '0.1°C',
                'faixa_medicao' => '-50 a +400°C',
                'mpe' => '±1.0°C',
                'norma_aplicavel' => 'IEC 60751',
            ],
            [
                'divisao_origem' => 'MSMI',
                'tipo' => 'Micrômetro',
                'categoria' => 'Dimensional',
                'fabricante' => 'Starrett',
                'modelo' => 'T436',
                'serie' => 'STR654321',
                'codigo_interno' => 'EQ-004',
                'descricao' => 'Micrômetro Externo 0-25mm',
                'local_fisico_atual' => 'Oficina Mecânica',
                'ciclo_meses' => 12,
                'criticidade' => 'Alta',
                'classe_metrologica' => 'Classe 1',
                'resolucao' => '0.001mm',
                'faixa_medicao' => '0-25mm',
                'mpe' => '±0.002mm',
                'norma_aplicavel' => 'ABNT NBR 6670',
            ],
            [
                'divisao_origem' => 'CMASM',
                'tipo' => 'Manômetro',
                'categoria' => 'Pressão',
                'fabricante' => 'Presys',
                'modelo' => 'T-5000',
                'serie' => 'PRE987654',
                'codigo_interno' => 'EQ-005',
                'descricao' => 'Manômetro Digital 0-1000 PSI',
                'local_fisico_atual' => 'Laboratório Pressão',
                'ciclo_meses' => 12,
                'criticidade' => 'Média',
                'classe_metrologica' => 'Classe 0.5',
                'resolucao' => '0.1 PSI',
                'faixa_medicao' => '0-1000 PSI',
                'mpe' => '±0.25%',
                'norma_aplicavel' => 'ASME B40.100',
            ],
        ];

        foreach ($equipamentos as $eq) {
            Equipamento::create($eq);
        }

        $this->command->info('Equipamentos criados com sucesso!');
    }
}

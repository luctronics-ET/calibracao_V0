<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamento;
use App\Models\Laboratorio;
use Illuminate\Support\Facades\DB;

class EquipamentoTestSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('equipamentos')->delete();

        $equipamentos = [
            [
                'equipamento_classe' => 'Multímetro',
                'equipamento_tipo' => 'Digital',
                'equipamento_fabricante' => 'Fluke',
                'equipamento_modelo' => '87V',
                'equipamento_serial' => 'FL87V12345',
                'equipamento_codigo_interno' => 'EQ-001',
                'equipamento_resolucao' => '0.01V',
                'equipamento_faixa_medicao' => '0-1000V DC',
                'equipamento_periodicidade_meses' => 12,
                'equipamento_status' => 'ativo',
                'bloqueado_para_uso' => false,
                'proxima_calibracao_prevista' => now()->addMonths(6),
                // Campos IGP
                'freq_uso' => 3, // alta
                'nec_critica' => 3, // alta
                'abundancia' => 1, // único
                'crit_metrol' => 3, // alta
                'custo_indisp' => 3, // alto
            ],
            [
                'equipamento_classe' => 'Paquímetro',
                'equipamento_tipo' => 'Digital',
                'equipamento_fabricante' => 'Mitutoyo',
                'equipamento_modelo' => '500-196-30',
                'equipamento_serial' => 'MIT50019612',
                'equipamento_codigo_interno' => 'EQ-002',
                'equipamento_resolucao' => '0.01mm',
                'equipamento_faixa_medicao' => '0-150mm',
                'equipamento_periodicidade_meses' => 12,
                'equipamento_status' => 'ativo',
                'bloqueado_para_uso' => false,
                'proxima_calibracao_prevista' => now()->addMonths(3),
                // Campos IGP
                'freq_uso' => 3,
                'nec_critica' => 2,
                'abundancia' => 2,
                'crit_metrol' => 3,
                'custo_indisp' => 2,
            ],
            [
                'equipamento_classe' => 'Micrômetro',
                'equipamento_tipo' => 'Externo',
                'equipamento_fabricante' => 'Starrett',
                'equipamento_modelo' => '436.1XFL-25',
                'equipamento_serial' => 'STR43625001',
                'equipamento_codigo_interno' => 'EQ-003',
                'equipamento_resolucao' => '0.001mm',
                'equipamento_faixa_medicao' => '0-25mm',
                'equipamento_periodicidade_meses' => 12,
                'equipamento_status' => 'ativo',
                'bloqueado_para_uso' => false,
                'proxima_calibracao_prevista' => now()->addMonths(9),
                // Campos IGP
                'freq_uso' => 2,
                'nec_critica' => 2,
                'abundancia' => 2,
                'crit_metrol' => 3,
                'custo_indisp' => 2,
            ],
            [
                'equipamento_classe' => 'Termômetro',
                'equipamento_tipo' => 'Digital',
                'equipamento_fabricante' => 'Testo',
                'equipamento_modelo' => '110',
                'equipamento_serial' => 'TES110001',
                'equipamento_codigo_interno' => 'EQ-004',
                'equipamento_resolucao' => '0.1°C',
                'equipamento_faixa_medicao' => '-50 a 150°C',
                'equipamento_periodicidade_meses' => 12,
                'equipamento_status' => 'ativo',
                'bloqueado_para_uso' => false,
                'proxima_calibracao_prevista' => now()->subDays(15), // Vencido
                // Campos IGP
                'freq_uso' => 2,
                'nec_critica' => 3,
                'abundancia' => 3,
                'crit_metrol' => 2,
                'custo_indisp' => 2,
            ],
            [
                'equipamento_classe' => 'Balança',
                'equipamento_tipo' => 'Analítica',
                'equipamento_fabricante' => 'Shimadzu',
                'equipamento_modelo' => 'AUY220',
                'equipamento_serial' => 'SHI220001',
                'equipamento_codigo_interno' => 'EQ-005',
                'equipamento_resolucao' => '0.0001g',
                'equipamento_faixa_medicao' => '0-220g',
                'equipamento_periodicidade_meses' => 6,
                'equipamento_status' => 'ativo',
                'bloqueado_para_uso' => false,
                'proxima_calibracao_prevista' => now()->addDays(15), // Vencendo
                // Campos IGP
                'freq_uso' => 3,
                'nec_critica' => 3,
                'abundancia' => 1,
                'crit_metrol' => 3,
                'custo_indisp' => 3,
            ],
        ];

        foreach ($equipamentos as $equip) {
            // Calcular IGP
            $igp = ($equip['freq_uso'] * $equip['nec_critica'] * $equip['crit_metrol']) /
                ($equip['abundancia'] * $equip['custo_indisp']);

            $equip['igp_calculado'] = round($igp, 2);

            // Determinar criticidade
            if ($igp >= 20) {
                $equip['criticidade_equipamento'] = 'alta';
            } elseif ($igp >= 10) {
                $equip['criticidade_equipamento'] = 'media';
            } else {
                $equip['criticidade_equipamento'] = 'baixa';
            }

            Equipamento::create($equip);
        }

        $this->command->info('5 equipamentos de teste criados com sucesso!');
    }
}

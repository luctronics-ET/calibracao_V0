<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contrato;
use App\Models\Laboratorio;
use Illuminate\Support\Facades\DB;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contratos')->delete();

        $labcal = Laboratorio::where('nome', 'like', '%Labcal%')->first();
        $metrolab = Laboratorio::where('nome', 'like', '%Metrolab%')->first();
        $calibramais = Laboratorio::where('nome', 'like', '%Calibra+%')->first();

        if (!$labcal || !$metrolab || !$calibramais) {
            $this->command->warn('Execute LaboratorioSeeder primeiro!');
            return;
        }

        $contratos = [
            [
                'laboratorio_id' => $labcal->id,
                'edital_num' => 'ED-2024-001',
                'vigencia_ini' => '2024-01-01',
                'vigencia_fim' => '2024-12-31',
                'preco_unitario' => 150.00,
                'anexos' => 'Contrato anual para calibração de instrumentos',
            ],
            [
                'laboratorio_id' => $metrolab->id,
                'edital_num' => 'ED-2024-002',
                'vigencia_ini' => '2024-03-01',
                'vigencia_fim' => '2025-02-28',
                'preco_unitario' => 180.00,
                'anexos' => 'Contrato para calibração dimensional',
            ],
            [
                'laboratorio_id' => $calibramais->id,
                'edital_num' => 'ED-2024-003',
                'vigencia_ini' => '2024-06-01',
                'vigencia_fim' => '2024-11-30',
                'preco_unitario' => 120.00,
                'anexos' => 'Contrato semestral',
            ],
        ];

        foreach ($contratos as $contrato) {
            Contrato::create($contrato);
        }

        $this->command->info('Contratos criados com sucesso!');
    }
}

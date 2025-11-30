<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Equipamento;
use App\Models\Calibracao;
use App\Models\Laboratorio;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalibracaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_calibracao()
    {
        $equipamento = Equipamento::factory()->create();
        $laboratorio = Laboratorio::factory()->create();

        $data = [
            'equipamento_id' => $equipamento->id,
            'laboratorio_id' => $laboratorio->id,
            'data_calibracao' => '2025-01-15',
            'data_proxima_calibracao' => '2026-01-15',
            'resultado' => 'aprovado',
            'status' => 'em_uso',
        ];

        $response = $this->post('/calibracoes', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('calibracoes', [
            'equipamento_id' => $equipamento->id,
            'resultado' => 'aprovado',
        ]);
    }

    public function test_calibracao_updates_equipamento_proxima_calibracao()
    {
        $equipamento = Equipamento::factory()->create([
            'data_proxima_calibracao' => null,
        ]);
        $laboratorio = Laboratorio::factory()->create();

        Calibracao::create([
            'equipamento_id' => $equipamento->id,
            'laboratorio_id' => $laboratorio->id,
            'data_calibracao' => now(),
            'data_proxima_calibracao' => now()->addYear(),
            'resultado' => 'aprovado',
            'status' => 'em_uso',
        ]);

        $equipamento->refresh();

        $this->assertNotNull($equipamento->data_proxima_calibracao);
    }

    public function test_can_list_calibracoes()
    {
        Calibracao::factory()->count(5)->create();

        $response = $this->get('/calibracoes');

        $response->assertStatus(200);
        $response->assertViewIs('calibracoes.index');
    }
}

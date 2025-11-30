<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Equipamento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipamentoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_equipamentos()
    {
        Equipamento::factory()->count(5)->create();

        $response = $this->get('/equipamentos');

        $response->assertStatus(200);
        $response->assertViewIs('equipamentos.index');
        $response->assertViewHas('equipamentos');
    }

    public function test_can_create_equipamento()
    {
        $data = [
            'codigo_interno' => 'TEST-001',
            'tipo' => 'MANÔMETRO',
            'fabricante' => 'Test Fabricante',
            'modelo' => 'Model X',
            'numero_serie' => 'SN12345',
            'faixa_medicao' => '0-100 bar',
            'resolucao' => '0.1 bar',
            'classe_exatidao' => '1.0',
            'status' => 'ativo',
        ];

        $response = $this->post('/equipamentos', $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('equipamentos', [
            'codigo_interno' => 'TEST-001',
            'tipo' => 'MANÔMETRO',
        ]);
    }

    public function test_igp_calculation()
    {
        $equipamento = Equipamento::factory()->create([
            'frequencia_uso' => 3,
            'necessidade_critica' => 3,
            'abundancia' => 1,
            'criticidade_metrologica' => 3,
            'custo_indisponibilidade' => 1,
        ]);

        // IGP = (3 * 3 * 3) / (1 * 1) = 27
        $this->assertEquals(27, $equipamento->igp);
        $this->assertEquals('alta', $equipamento->classificacao);
    }

    public function test_igp_calculation_media()
    {
        $equipamento = Equipamento::factory()->create([
            'frequencia_uso' => 2,
            'necessidade_critica' => 2,
            'abundancia' => 2,
            'criticidade_metrologica' => 2,
            'custo_indisponibilidade' => 1,
        ]);

        // IGP = (2 * 2 * 2) / (2 * 1) = 4
        $this->assertEquals(4, $equipamento->igp);
        $this->assertEquals('baixa', $equipamento->classificacao);
    }

    public function test_can_update_equipamento()
    {
        $equipamento = Equipamento::factory()->create();

        $data = [
            'codigo_interno' => $equipamento->codigo_interno,
            'tipo' => 'UPDATED TYPE',
            'fabricante' => $equipamento->fabricante,
            'modelo' => $equipamento->modelo,
            'numero_serie' => $equipamento->numero_serie,
            'status' => 'ativo',
        ];

        $response = $this->put("/equipamentos/{$equipamento->id}", $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('equipamentos', [
            'id' => $equipamento->id,
            'tipo' => 'UPDATED TYPE',
        ]);
    }

    public function test_can_delete_equipamento()
    {
        $equipamento = Equipamento::factory()->create();

        $response = $this->delete("/equipamentos/{$equipamento->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('equipamentos', [
            'id' => $equipamento->id,
        ]);
    }
}

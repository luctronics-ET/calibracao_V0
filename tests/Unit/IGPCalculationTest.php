<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Equipamento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IGPCalculationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test IGP calculation for alta prioridade
     */
    public function test_igp_alta_prioridade()
    {
        $equipamento = new Equipamento([
            'codigo_interno' => 'TEST-001',
            'tipo' => 'TEST',
            'frequencia_uso' => 3,
            'necessidade_critica' => 3,
            'abundancia' => 1,
            'criticidade_metrologica' => 3,
            'custo_indisponibilidade' => 1,
            'status' => 'ativo',
        ]);

        $equipamento->save();

        // IGP = (3 * 3 * 3) / (1 * 1) = 27
        $this->assertEquals(27, $equipamento->igp);
        $this->assertEquals('alta', $equipamento->classificacao);
    }

    /**
     * Test IGP calculation for media prioridade
     */
    public function test_igp_media_prioridade()
    {
        $equipamento = new Equipamento([
            'codigo_interno' => 'TEST-002',
            'tipo' => 'TEST',
            'frequencia_uso' => 2,
            'necessidade_critica' => 3,
            'abundancia' => 2,
            'criticidade_metrologica' => 2,
            'custo_indisponibilidade' => 1,
            'status' => 'ativo',
        ]);

        $equipamento->save();

        // IGP = (2 * 3 * 2) / (2 * 1) = 6
        $this->assertEquals(6, $equipamento->igp);
        $this->assertEquals('baixa', $equipamento->classificacao);
    }

    /**
     * Test IGP calculation for baixa prioridade
     */
    public function test_igp_baixa_prioridade()
    {
        $equipamento = new Equipamento([
            'codigo_interno' => 'TEST-003',
            'tipo' => 'TEST',
            'frequencia_uso' => 1,
            'necessidade_critica' => 1,
            'abundancia' => 3,
            'criticidade_metrologica' => 1,
            'custo_indisponibilidade' => 2,
            'status' => 'ativo',
        ]);

        $equipamento->save();

        // IGP = (1 * 1 * 1) / (3 * 2) = 0.16... = 0
        $this->assertEquals(0, $equipamento->igp);
        $this->assertEquals('baixa', $equipamento->classificacao);
    }

    /**
     * Test IGP não calculado quando campos incompletos
     */
    public function test_igp_not_calculated_when_incomplete()
    {
        $equipamento = new Equipamento([
            'codigo_interno' => 'TEST-004',
            'tipo' => 'TEST',
            'frequencia_uso' => 2,
            'necessidade_critica' => null, // campo faltando
            'abundancia' => 1,
            'status' => 'ativo',
        ]);

        $equipamento->save();

        $this->assertNull($equipamento->igp);
        $this->assertNull($equipamento->classificacao);
    }

    /**
     * Test IGP recalculado ao atualizar
     */
    public function test_igp_recalculated_on_update()
    {
        $equipamento = Equipamento::create([
            'codigo_interno' => 'TEST-005',
            'tipo' => 'TEST',
            'frequencia_uso' => 1,
            'necessidade_critica' => 1,
            'abundancia' => 1,
            'criticidade_metrologica' => 1,
            'custo_indisponibilidade' => 1,
            'status' => 'ativo',
        ]);

        // IGP inicial = (1 * 1 * 1) / (1 * 1) = 1
        $this->assertEquals(1, $equipamento->igp);

        // Atualizar valores
        $equipamento->update([
            'frequencia_uso' => 3,
            'necessidade_critica' => 3,
            'criticidade_metrologica' => 3,
        ]);

        // Novo IGP = (3 * 3 * 3) / (1 * 1) = 27
        $this->assertEquals(27, $equipamento->igp);
        $this->assertEquals('alta', $equipamento->classificacao);
    }
}

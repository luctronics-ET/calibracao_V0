<?php

namespace App\Services;

use App\Models\Equipamento;
use App\Models\Calibracao;
use Carbon\Carbon;

class CalibracaoService
{
    /**
     * Calcula a próxima data de calibração baseado na última calibração e ciclo do equipamento.
     *
     * @param Equipamento $equipamento
     * @return array ['data_proxima_calibracao' => Carbon|null, 'status_calibracao' => string]
     */
    public function calcularProximaCalibracao(Equipamento $equipamento): array
    {
        // Buscar a última calibração do equipamento
        $ultimaCalibracao = Calibracao::where('equipamento_id', $equipamento->id)
            ->orderBy('data_calibracao', 'desc')
            ->first();

        // Se não houver calibração, retorna sem calibração
        if (!$ultimaCalibracao) {
            return [
                'data_proxima_calibracao' => null,
                'status_calibracao' => 'sem_calibracao'
            ];
        }

        // Usar data de validade se existir, senão calcular baseado na data de calibração + ciclo
        if ($ultimaCalibracao->data_validade) {
            $dataProxima = Carbon::parse($ultimaCalibracao->data_validade);
        } else {
            $cicloMeses = $equipamento->ciclo_meses ?? 12;
            $dataProxima = Carbon::parse($ultimaCalibracao->data_calibracao)->addMonths($cicloMeses);
        }

        // Calcular status baseado na data atual
        $status = $this->calcularStatus($dataProxima);

        return [
            'data_proxima_calibracao' => $dataProxima,
            'status_calibracao' => $status
        ];
    }

    /**
     * Calcula o status da calibração baseado na data de vencimento.
     *
     * @param Carbon $dataProxima
     * @return string
     */
    protected function calcularStatus(Carbon $dataProxima): string
    {
        $hoje = Carbon::today();
        $diasRestantes = $hoje->diffInDays($dataProxima, false);

        if ($diasRestantes < 0) {
            return 'vencida'; // Já passou da data
        } elseif ($diasRestantes <= 7) {
            return 'critica'; // Vence em até 7 dias
        } elseif ($diasRestantes <= 30) {
            return 'proxima'; // Vence em até 30 dias
        } else {
            return 'em_dia'; // Mais de 30 dias
        }
    }

    /**
     * Atualiza a data de próxima calibração do equipamento.
     *
     * @param Equipamento $equipamento
     * @return void
     */
    public function atualizarProximaCalibracao(Equipamento $equipamento): void
    {
        $resultado = $this->calcularProximaCalibracao($equipamento);

        $equipamento->update([
            'data_proxima_calibracao' => $resultado['data_proxima_calibracao'],
            'status_calibracao' => $resultado['status_calibracao']
        ]);
    }

    /**
     * Atualiza todos os equipamentos que possuem calibrações.
     *
     * @return int Quantidade de equipamentos atualizados
     */
    public function atualizarTodosEquipamentos(): int
    {
        $equipamentos = Equipamento::all();
        $atualizados = 0;

        foreach ($equipamentos as $equipamento) {
            $this->atualizarProximaCalibracao($equipamento);
            $atualizados++;
        }

        return $atualizados;
    }

    /**
     * Retorna equipamentos que precisam de calibração urgente.
     *
     * @param int $dias Quantidade de dias para considerar urgente (padrão: 30)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function equipamentosUrgentes(int $dias = 30)
    {
        $dataLimite = Carbon::today()->addDays($dias);

        return Equipamento::whereNotNull('data_proxima_calibracao')
            ->where('data_proxima_calibracao', '<=', $dataLimite)
            ->whereIn('status_calibracao', ['vencida', 'critica', 'proxima'])
            ->orderBy('data_proxima_calibracao')
            ->get();
    }

    /**
     * Retorna equipamentos com calibração vencida.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function equipamentosVencidos()
    {
        return Equipamento::where('status_calibracao', 'vencida')
            ->orderBy('data_proxima_calibracao')
            ->get();
    }
}

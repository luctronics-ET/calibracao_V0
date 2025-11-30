<?php

namespace App\Observers;

use App\Models\Equipamento;

class EquipamentoObserver
{
    /**
     * Handle the Equipamento "saving" event.
     * Calcula o IGP antes de salvar o equipamento.
     */
    public function saving(Equipamento $equipamento): void
    {
        $this->calcularIGP($equipamento);
    }

    /**
     * Calcula o Índice de Grau de Prioridade (IGP) do equipamento.
     * 
     * Fórmula: IGP = (frequencia_uso × necessidade_critica × criticidade_metrologica) ÷ (abundancia × custo_indisponibilidade)
     * 
     * Classificação:
     * - Alta: IGP >= 20 (equipamentos críticos, prioridade máxima)
     * - Média: IGP entre 10-19 (equipamentos importantes)
     * - Baixa: IGP < 10 (equipamentos de rotina)
     */
    private function calcularIGP(Equipamento $equipamento): void
    {
        // Verificar se todos os campos necessários estão preenchidos
        if (
            !$equipamento->frequencia_uso ||
            !$equipamento->necessidade_critica ||
            !$equipamento->abundancia ||
            !$equipamento->criticidade_metrologica ||
            !$equipamento->custo_indisponibilidade
        ) {
            // Se algum campo está vazio, limpar IGP e classificação
            $equipamento->igp = null;
            $equipamento->classificacao = null;
            return;
        }

        // Validar valores (devem estar entre 1 e 3)
        if (
            $equipamento->frequencia_uso < 1 || $equipamento->frequencia_uso > 3 ||
            $equipamento->necessidade_critica < 1 || $equipamento->necessidade_critica > 3 ||
            $equipamento->abundancia < 1 || $equipamento->abundancia > 3 ||
            $equipamento->criticidade_metrologica < 1 || $equipamento->criticidade_metrologica > 3 ||
            $equipamento->custo_indisponibilidade < 1 || $equipamento->custo_indisponibilidade > 3
        ) {
            $equipamento->igp = null;
            $equipamento->classificacao = null;
            return;
        }

        // Calcular numerador
        $numerador = $equipamento->frequencia_uso
            * $equipamento->necessidade_critica
            * $equipamento->criticidade_metrologica;

        // Calcular denominador
        $denominador = $equipamento->abundancia
            * $equipamento->custo_indisponibilidade;

        // Evitar divisão por zero (não deveria ocorrer, mas por segurança)
        if ($denominador == 0) {
            $equipamento->igp = null;
            $equipamento->classificacao = null;
            return;
        }

        // Calcular IGP
        $igp = round($numerador / $denominador);
        $equipamento->igp = $igp;

        // Determinar classificação baseada no IGP
        if ($igp >= 20) {
            $equipamento->classificacao = 'alta';
        } elseif ($igp >= 10) {
            $equipamento->classificacao = 'media';
        } else {
            $equipamento->classificacao = 'baixa';
        }
    }

    /**
     * Handle the Equipamento "created" event.
     */
    public function created(Equipamento $equipamento): void
    {
        // Registrar log de criação se necessário
    }

    /**
     * Handle the Equipamento "updated" event.
     */
    public function updated(Equipamento $equipamento): void
    {
        // Verificar se campos IGP foram alterados
        if ($equipamento->wasChanged([
            'frequencia_uso',
            'necessidade_critica',
            'abundancia',
            'criticidade_metrologica',
            'custo_indisponibilidade'
        ])) {
            // Log de alteração de IGP se necessário
        }
    }
}

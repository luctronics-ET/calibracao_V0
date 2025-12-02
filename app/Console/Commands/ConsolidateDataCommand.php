<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Equipamento;
use App\Models\Calibracao;

class ConsolidateDataCommand extends Command
{
    protected $signature = 'data:consolidate';
    protected $description = 'Consolida dados duplicados entre tabelas de equipamentos e calibrações';

    public function handle()
    {
        $this->info('Iniciando consolidação de dados...');

        DB::beginTransaction();

        try {
            // 1. Vincular equipamentos com seus laboratórios através de equipamento_local_calibracao
            $this->info('Vinculando equipamentos aos laboratórios...');
            $equipamentos = Equipamento::whereNotNull('equipamento_local_calibracao')
                ->where('equipamento_local_calibracao', '!=', '')
                ->get();

            $labsMap = DB::table('laboratorios')->pluck('id', 'nome')->toArray();
            $vinculados = 0;

            foreach ($equipamentos as $eq) {
                $labNome = trim($eq->equipamento_local_calibracao);

                // Tentar encontrar laboratório exato ou similar
                $labId = null;
                if (isset($labsMap[$labNome])) {
                    $labId = $labsMap[$labNome];
                } else {
                    // Buscar por match parcial
                    foreach ($labsMap as $nome => $id) {
                        if (stripos($labNome, $nome) !== false || stripos($nome, $labNome) !== false) {
                            $labId = $id;
                            break;
                        }
                    }
                }

                if ($labId && !$eq->laboratorio_id) {
                    $eq->laboratorio_id = $labId;
                    $eq->save();
                    $vinculados++;
                }
            }

            $this->info("Laboratórios vinculados: $vinculados");

            // 2. Criar campo data_calibracao nas calibrações baseado em equipamento_data_ultima_calibracao
            $this->info('Atualizando datas de calibração...');
            $calibs = Calibracao::with('equipamento')->get();
            $datasAtualizadas = 0;

            foreach ($calibs as $calib) {
                if ($calib->equipamento && $calib->equipamento->equipamento_data_ultima_calibracao) {
                    $calib->data_calibracao = $calib->equipamento->equipamento_data_ultima_calibracao;
                    $calib->save();
                    $datasAtualizadas++;
                }
            }

            $this->info("Datas de calibração atualizadas: $datasAtualizadas");

            // 3. Definir resultado como "aprovado" para calibrações com status CALIBRADO
            $this->info('Atualizando resultados das calibrações...');
            $resultadosAtualizados = 0;

            foreach ($calibs as $calib) {
                if ($calib->equipamento) {
                    if ($calib->equipamento->equipamento_certificado_status === 'CALIBRADO') {
                        $calib->resultado = 'aprovado';
                    } elseif ($calib->equipamento->equipamento_certificado_status === 'DESCALIBRADO') {
                        $calib->resultado = 'reprovado';
                    }

                    // Adicionar número de certificado se disponível
                    if ($calib->equipamento->equipamento_certificado_pdf) {
                        $calib->certificado_num = basename($calib->equipamento->equipamento_certificado_pdf, '.pdf');
                        $calib->arquivo_certificado = $calib->equipamento->equipamento_certificado_pdf;
                    }

                    $calib->save();
                    $resultadosAtualizados++;
                }
            }

            $this->info("Resultados atualizados: $resultadosAtualizados");

            // 4. Estatísticas finais
            $this->newLine();
            $this->info('=== ESTATÍSTICAS APÓS CONSOLIDAÇÃO ===');
            $this->table(
                ['Métrica', 'Valor'],
                [
                    ['Equipamentos com laboratório', Equipamento::whereNotNull('laboratorio_id')->count()],
                    ['Calibrações com data', Calibracao::whereNotNull('data_calibracao')->count()],
                    ['Calibrações com resultado', Calibracao::whereNotNull('resultado')->count()],
                    ['Calibrações aprovadas', Calibracao::where('resultado', 'aprovado')->count()],
                    ['Calibrações reprovadas', Calibracao::where('resultado', 'reprovado')->count()],
                    ['Calibrações com certificado', Calibracao::whereNotNull('certificado_num')->count()],
                ]
            );

            DB::commit();
            $this->info('Consolidação concluída com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Erro durante consolidação: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

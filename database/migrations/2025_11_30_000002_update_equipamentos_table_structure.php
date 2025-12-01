<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Fase 1: Remover colunas antigas uma por uma (SQLite limitation)
        $columnsToRemove = [
            'divisao_origem',
            'categoria',
            'serie',
            'codigo_interno',
            'descricao',
            'local_fisico_atual',
            'ciclo_meses',
            'criticidade',
            'classe_metrologica',
            'mpe',
            'norma_aplicavel',
            'data_proxima_calibracao',
            'status_calibracao'
        ];

        foreach ($columnsToRemove as $column) {
            if (Schema::hasColumn('equipamentos', $column)) {
                Schema::table('equipamentos', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }

        // Fase 2: Renomear colunas existentes uma por uma
        $columnsToRename = [
            'tipo' => 'equipamento_tipo',
            'fabricante' => 'equipamento_fabricante',
            'modelo' => 'equipamento_modelo',
            'resolucao' => 'equipamento_resolucao',
            'faixa_medicao' => 'equipamento_faixa_medicao',
            'foto' => 'equipamento_foto',
        ];

        foreach ($columnsToRename as $oldName => $newName) {
            if (Schema::hasColumn('equipamentos', $oldName) && !Schema::hasColumn('equipamentos', $newName)) {
                Schema::table('equipamentos', function (Blueprint $table) use ($oldName, $newName) {
                    $table->renameColumn($oldName, $newName);
                });
            }
        }

        // Fase 3: Adicionar novas colunas
        Schema::table('equipamentos', function (Blueprint $table) {
            if (!Schema::hasColumn('equipamentos', 'equipamento_classe')) {
                $table->string('equipamento_classe')->nullable()->after('id');
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_serial')) {
                $table->string('equipamento_serial')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_codigo_interno')) {
                $table->string('equipamento_codigo_interno')->nullable();
            }

            // Dimensões físicas
            if (!Schema::hasColumn('equipamentos', 'equipamento_altura_mm')) {
                $table->integer('equipamento_altura_mm')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_largura_mm')) {
                $table->integer('equipamento_largura_mm')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_comprimento_mm')) {
                $table->integer('equipamento_comprimento_mm')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_tensao_v')) {
                $table->integer('equipamento_tensao_v')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_potencia_w')) {
                $table->integer('equipamento_potencia_w')->nullable();
            }

            // Características metrológicas
            if (!Schema::hasColumn('equipamentos', 'equipamento_incerteza_nominal')) {
                $table->string('equipamento_incerteza_nominal')->nullable();
            }

            // Dados de calibração
            if (!Schema::hasColumn('equipamentos', 'equipamento_data_ultima_calibracao')) {
                $table->date('equipamento_data_ultima_calibracao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_data_proxima_calibracao')) {
                $table->date('equipamento_data_proxima_calibracao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_periodicidade_meses')) {
                $table->integer('equipamento_periodicidade_meses')->nullable();
            }

            // Status e localização
            if (!Schema::hasColumn('equipamentos', 'equipamento_status')) {
                $table->string('equipamento_status')->default('ativo');
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_localizacao')) {
                $table->string('equipamento_localizacao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_setor')) {
                $table->string('equipamento_setor')->nullable();
            }

            // Documentação
            if (!Schema::hasColumn('equipamentos', 'equipamento_manual_pdf')) {
                $table->string('equipamento_manual_pdf')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_link_fabricante')) {
                $table->string('equipamento_link_fabricante')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_instrucao_uso')) {
                $table->text('equipamento_instrucao_uso')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_instrucao_operacao')) {
                $table->text('equipamento_instrucao_operacao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_instrucao_seguranca')) {
                $table->text('equipamento_instrucao_seguranca')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_comentarios')) {
                $table->text('equipamento_comentarios')->nullable();
            }

            // Dados financeiros
            if (!Schema::hasColumn('equipamentos', 'valor_aquisicao')) {
                $table->decimal('valor_aquisicao', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_custo_estimado')) {
                $table->decimal('equipamento_custo_estimado', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'data_aquisicao')) {
                $table->date('data_aquisicao')->nullable();
            }

            // Certificação
            if (!Schema::hasColumn('equipamentos', 'equipamento_certificado_pdf')) {
                $table->string('equipamento_certificado_pdf')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_certificado_status')) {
                $table->string('equipamento_certificado_status')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_local_calibracao')) {
                $table->string('equipamento_local_calibracao')->nullable();
            }

            // Matriz IGP - 5 fatores (valores de 1 a 3)
            if (!Schema::hasColumn('equipamentos', 'equipamento_frequencia_uso')) {
                $table->tinyInteger('equipamento_frequencia_uso')->nullable()
                    ->comment('1=Pouco usado, 2=Uso moderado, 3=Uso frequente');
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_necessidade_critica')) {
                $table->tinyInteger('equipamento_necessidade_critica')->nullable()
                    ->comment('1=Não crítico, 2=Moderadamente crítico, 3=Crítico');
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_abundancia')) {
                $table->tinyInteger('equipamento_abundancia')->nullable()
                    ->comment('1=Abundante, 2=Disponibilidade média, 3=Escasso');
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_custo_indisponibilidade')) {
                $table->tinyInteger('equipamento_custo_indisponibilidade')->nullable()
                    ->comment('1=Baixo custo, 2=Custo médio, 3=Alto custo');
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_criticidade_metrologica')) {
                $table->tinyInteger('equipamento_criticidade_metrologica')->nullable()
                    ->comment('1=Baixa criticidade, 2=Média criticidade, 3=Alta criticidade');
            }

            // IGP calculado (soma: 5-15)
            if (!Schema::hasColumn('equipamentos', 'equipamento_igp')) {
                $table->integer('equipamento_igp')->default(0)
                    ->comment('Índice de Grau de Prioridade (soma dos 5 fatores: 5-15)');
            }
            if (!Schema::hasColumn('equipamentos', 'equipamento_classificacao')) {
                $table->string('equipamento_classificacao')->default('baixa')
                    ->comment('baixa (<7), media (7-11), alta (>=12)');
            }
        });
    }

    public function down()
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            // Remover colunas adicionadas
            $newColumns = [
                'equipamento_classe',
                'equipamento_serial',
                'equipamento_codigo_interno',
                'equipamento_altura_mm',
                'equipamento_largura_mm',
                'equipamento_comprimento_mm',
                'equipamento_tensao_v',
                'equipamento_potencia_w',
                'equipamento_incerteza_nominal',
                'equipamento_data_ultima_calibracao',
                'equipamento_data_proxima_calibracao',
                'equipamento_periodicidade_meses',
                'equipamento_status',
                'equipamento_localizacao',
                'equipamento_setor',
                'equipamento_manual_pdf',
                'equipamento_link_fabricante',
                'equipamento_instrucao_uso',
                'equipamento_instrucao_operacao',
                'equipamento_instrucao_seguranca',
                'equipamento_comentarios',
                'valor_aquisicao',
                'equipamento_custo_estimado',
                'data_aquisicao',
                'equipamento_certificado_pdf',
                'equipamento_certificado_status',
                'equipamento_local_calibracao',
                'equipamento_frequencia_uso',
                'equipamento_necessidade_critica',
                'equipamento_abundancia',
                'equipamento_custo_indisponibilidade',
                'equipamento_criticidade_metrologica',
                'equipamento_igp',
                'equipamento_classificacao'
            ];

            $existingColumns = [];
            foreach ($newColumns as $column) {
                if (Schema::hasColumn('equipamentos', $column)) {
                    $existingColumns[] = $column;
                }
            }

            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });

        // Renomear de volta
        Schema::table('equipamentos', function (Blueprint $table) {
            if (Schema::hasColumn('equipamentos', 'equipamento_tipo')) {
                $table->renameColumn('equipamento_tipo', 'tipo');
            }
            if (Schema::hasColumn('equipamentos', 'equipamento_fabricante')) {
                $table->renameColumn('equipamento_fabricante', 'fabricante');
            }
            if (Schema::hasColumn('equipamentos', 'equipamento_modelo')) {
                $table->renameColumn('equipamento_modelo', 'modelo');
            }
            if (Schema::hasColumn('equipamentos', 'equipamento_resolucao')) {
                $table->renameColumn('equipamento_resolucao', 'resolucao');
            }
            if (Schema::hasColumn('equipamentos', 'equipamento_faixa_medicao')) {
                $table->renameColumn('equipamento_faixa_medicao', 'faixa_medicao');
            }
            if (Schema::hasColumn('equipamentos', 'equipamento_foto')) {
                $table->renameColumn('equipamento_foto', 'foto');
            }
        });

        // Recriar colunas antigas
        Schema::table('equipamentos', function (Blueprint $table) {
            $table->string('divisao_origem')->nullable();
            $table->string('categoria')->nullable();
            $table->string('serie')->nullable();
            $table->string('codigo_interno')->nullable();
            $table->text('descricao')->nullable();
            $table->string('local_fisico_atual')->nullable();
            $table->integer('ciclo_meses')->default(12);
            $table->string('criticidade')->nullable();
            $table->string('classe_metrologica')->nullable();
            $table->string('mpe')->nullable();
            $table->string('norma_aplicavel')->nullable();
            $table->date('data_proxima_calibracao')->nullable();
            $table->string('status_calibracao')->default('em_dia');
        });
    }
};

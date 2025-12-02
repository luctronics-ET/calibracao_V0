<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adicionar campos faltantes na tabela equipamentos
        Schema::table('equipamentos', function (Blueprint $table) {
            // Campos do database_gptSQL.txt que estão faltando
            if (!Schema::hasColumn('equipamentos', 'categoria_metrologica')) {
                $table->string('categoria_metrologica')->nullable()->after('id');
            }
            if (!Schema::hasColumn('equipamentos', 'local_dotacao_id')) {
                $table->foreignId('local_dotacao_id')->nullable()->after('descricao')->constrained('locais')->onDelete('set null');
            }
            if (!Schema::hasColumn('equipamentos', 'localizacao_atual_id')) {
                $table->foreignId('localizacao_atual_id')->nullable()->after('local_dotacao_id')->constrained('locais')->onDelete('set null');
            }
            if (!Schema::hasColumn('equipamentos', 'classe_exatidao')) {
                $table->string('classe_exatidao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'intervalo_medicao_min')) {
                $table->decimal('intervalo_medicao_min', 15, 6)->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'intervalo_medicao_max')) {
                $table->decimal('intervalo_medicao_max', 15, 6)->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'cond_temp_operacao')) {
                $table->string('cond_temp_operacao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'cond_umidade_operacao')) {
                $table->string('cond_umidade_operacao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'cond_ambiente_restricoes')) {
                $table->text('cond_ambiente_restricoes')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'criticidade_equipamento')) {
                $table->string('criticidade_equipamento')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'intervalo_calibracao_meses')) {
                $table->integer('intervalo_calibracao_meses')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'justificativa_intervalo')) {
                $table->text('justificativa_intervalo')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'proxima_calibracao_prevista')) {
                $table->date('proxima_calibracao_prevista')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'custo_previsto_calibracao')) {
                $table->decimal('custo_previsto_calibracao', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'bloqueado_para_uso')) {
                $table->boolean('bloqueado_para_uso')->default(false);
            }
            if (!Schema::hasColumn('equipamentos', 'motivo_bloqueio')) {
                $table->text('motivo_bloqueio')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'responsavel_tecnico')) {
                $table->string('responsavel_tecnico')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'responsavel_cadastramento')) {
                $table->string('responsavel_cadastramento')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'observacoes_auditoria')) {
                $table->text('observacoes_auditoria')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'data_cadastro')) {
                $table->date('data_cadastro')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'ultima_atualizacao')) {
                $table->date('ultima_atualizacao')->nullable();
            }
        });

        // Adicionar campos faltantes na tabela laboratorios
        Schema::table('laboratorios', function (Blueprint $table) {
            if (!Schema::hasColumn('laboratorios', 'rbc_codigo')) {
                $table->string('rbc_codigo')->nullable()->after('nome');
            }
            if (!Schema::hasColumn('laboratorios', 'observacoes')) {
                $table->text('observacoes')->nullable();
            }
        });

        // Adicionar campos faltantes na tabela calibracoes
        Schema::table('calibracoes', function (Blueprint $table) {
            if (!Schema::hasColumn('calibracoes', 'rbc_codigo_laboratorio')) {
                $table->string('rbc_codigo_laboratorio')->nullable();
            }
            if (!Schema::hasColumn('calibracoes', 'rbc_metodo_calibracao')) {
                $table->string('rbc_metodo_calibracao')->nullable();
            }
            if (!Schema::hasColumn('calibracoes', 'rbc_incerteza_prevista')) {
                $table->string('rbc_incerteza_prevista')->nullable();
            }
            if (!Schema::hasColumn('calibracoes', 'rbc_capacidade_medicao')) {
                $table->string('rbc_capacidade_medicao')->nullable();
            }
            if (!Schema::hasColumn('calibracoes', 'conformidade_ilac_p14')) {
                $table->boolean('conformidade_ilac_p14')->default(false);
            }
            if (!Schema::hasColumn('calibracoes', 'estagio_cronograma_id')) {
                $table->foreignId('estagio_cronograma_id')->nullable()->constrained('cronograma_estagios')->onDelete('set null');
            }
            if (!Schema::hasColumn('calibracoes', 'localizacao_atual_id')) {
                $table->foreignId('localizacao_atual_id')->nullable()->constrained('locais')->onDelete('set null');
            }
            if (!Schema::hasColumn('calibracoes', 'solicitacao_id')) {
                $table->foreignId('solicitacao_id')->nullable()->constrained('solicitacoes')->onDelete('set null');
            }
            if (!Schema::hasColumn('calibracoes', 'logistica_et_id')) {
                $table->foreignId('logistica_et_id')->nullable()->constrained('logistica_et')->onDelete('set null');
            }
            if (!Schema::hasColumn('calibracoes', 'contrato_servico_id')) {
                $table->foreignId('contrato_servico_id')->nullable()->constrained('contratos')->onDelete('set null');
            }
            if (!Schema::hasColumn('calibracoes', 'arquivo_sha256')) {
                $table->string('arquivo_sha256')->nullable();
            }
            if (!Schema::hasColumn('calibracoes', 'proxima_calibracao_sugerida')) {
                $table->date('proxima_calibracao_sugerida')->nullable();
            }
            if (!Schema::hasColumn('calibracoes', 'data_registro')) {
                $table->date('data_registro')->nullable();
            }
        });

        // Adicionar campos faltantes na tabela lotes_envio
        Schema::table('lotes_envio', function (Blueprint $table) {
            if (!Schema::hasColumn('lotes_envio', 'contrato_servico_id')) {
                $table->foreignId('contrato_servico_id')->nullable()->after('id')->constrained('contratos')->onDelete('set null');
            }
            if (!Schema::hasColumn('lotes_envio', 'laboratorio_id')) {
                $table->foreignId('laboratorio_id')->nullable()->after('contrato_servico_id')->constrained('laboratorios')->onDelete('set null');
            }
            if (!Schema::hasColumn('lotes_envio', 'transporte_id')) {
                $table->foreignId('transporte_id')->nullable()->after('laboratorio_id')->constrained('transportes')->onDelete('set null');
            }
            if (!Schema::hasColumn('lotes_envio', 'descricao')) {
                $table->text('descricao')->nullable();
            }
            if (!Schema::hasColumn('lotes_envio', 'data_envio_lote')) {
                $table->date('data_envio_lote')->nullable();
            }
            if (!Schema::hasColumn('lotes_envio', 'data_recebimento_laboratorio')) {
                $table->date('data_recebimento_laboratorio')->nullable();
            }
            if (!Schema::hasColumn('lotes_envio', 'data_retorno_prevista')) {
                $table->date('data_retorno_prevista')->nullable();
            }
            if (!Schema::hasColumn('lotes_envio', 'data_retorno_recebida')) {
                $table->date('data_retorno_recebida')->nullable();
            }
            if (!Schema::hasColumn('lotes_envio', 'relatorio_envio')) {
                $table->text('relatorio_envio')->nullable();
            }
            if (!Schema::hasColumn('lotes_envio', 'relatorio_recebimento')) {
                $table->text('relatorio_recebimento')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Remover campos adicionados (em ordem reversa)
        Schema::table('lotes_envio', function (Blueprint $table) {
            $table->dropForeign(['contrato_servico_id']);
            $table->dropForeign(['laboratorio_id']);
            $table->dropForeign(['transporte_id']);
            $table->dropColumn([
                'contrato_servico_id',
                'laboratorio_id',
                'transporte_id',
                'descricao',
                'data_envio_lote',
                'data_recebimento_laboratorio',
                'data_retorno_prevista',
                'data_retorno_recebida',
                'relatorio_envio',
                'relatorio_recebimento'
            ]);
        });

        Schema::table('calibracoes', function (Blueprint $table) {
            $table->dropForeign(['estagio_cronograma_id']);
            $table->dropForeign(['localizacao_atual_id']);
            $table->dropForeign(['solicitacao_id']);
            $table->dropForeign(['logistica_et_id']);
            $table->dropForeign(['contrato_servico_id']);
            $table->dropColumn([
                'rbc_codigo_laboratorio',
                'rbc_metodo_calibracao',
                'rbc_incerteza_prevista',
                'rbc_capacidade_medicao',
                'conformidade_ilac_p14',
                'estagio_cronograma_id',
                'localizacao_atual_id',
                'solicitacao_id',
                'logistica_et_id',
                'contrato_servico_id',
                'arquivo_sha256',
                'proxima_calibracao_sugerida',
                'data_registro'
            ]);
        });

        Schema::table('laboratorios', function (Blueprint $table) {
            $table->dropColumn(['rbc_codigo', 'observacoes']);
        });

        Schema::table('equipamentos', function (Blueprint $table) {
            $table->dropForeign(['local_dotacao_id']);
            $table->dropForeign(['localizacao_atual_id']);
            $table->dropColumn([
                'categoria_metrologica',
                'local_dotacao_id',
                'localizacao_atual_id',
                'classe_exatidao',
                'intervalo_medicao_min',
                'intervalo_medicao_max',
                'cond_temp_operacao',
                'cond_umidade_operacao',
                'cond_ambiente_restricoes',
                'criticidade_equipamento',
                'intervalo_calibracao_meses',
                'justificativa_intervalo',
                'proxima_calibracao_prevista',
                'custo_previsto_calibracao',
                'bloqueado_para_uso',
                'motivo_bloqueio',
                'responsavel_tecnico',
                'responsavel_cadastramento',
                'observacoes_auditoria',
                'data_cadastro',
                'ultima_atualizacao'
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            // Campos de logística
            if (!Schema::hasColumn('equipamentos', 'numero_ordem_servico')) {
                $table->string('numero_ordem_servico')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'data_recebimento_et')) {
                $table->date('data_recebimento_et')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'data_saida_calibracao')) {
                $table->date('data_saida_calibracao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'data_recebimento_calibracao')) {
                $table->date('data_recebimento_calibracao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'data_entrega_divisao')) {
                $table->date('data_entrega_divisao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'observacoes_logistica')) {
                $table->text('observacoes_logistica')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'status_logistica')) {
                $table->string('status_logistica')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'relatorio_recebimento_et')) {
                $table->text('relatorio_recebimento_et')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'responsavel_divisao')) {
                $table->string('responsavel_divisao')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'responsavel_et')) {
                $table->string('responsavel_et')->nullable();
            }

            // Foreign keys
            if (!Schema::hasColumn('equipamentos', 'calibracao_id')) {
                $table->foreignId('calibracao_id')->nullable()->constrained('calibracoes')->onDelete('set null');
            }
            if (!Schema::hasColumn('equipamentos', 'contrato_servico_id')) {
                $table->unsignedBigInteger('contrato_servico_id')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'laboratorio_id')) {
                $table->foreignId('laboratorio_id')->nullable()->constrained('laboratorios')->onDelete('set null');
            }
            if (!Schema::hasColumn('equipamentos', 'logistica_et_id')) {
                $table->foreignId('logistica_et_id')->nullable()->constrained('logistica_et')->onDelete('set null');
            }
            if (!Schema::hasColumn('equipamentos', 'lote_id')) {
                $table->unsignedBigInteger('lote_id')->nullable();
            }
            if (!Schema::hasColumn('equipamentos', 'solicitacao_id')) {
                $table->foreignId('solicitacao_id')->nullable()->constrained('solicitacoes')->onDelete('set null');
            }
            if (!Schema::hasColumn('equipamentos', 'transporte_id')) {
                $table->foreignId('transporte_id')->nullable()->constrained('transportes')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            $table->dropColumn([
                'numero_ordem_servico',
                'data_recebimento_et',
                'data_saida_calibracao',
                'data_recebimento_calibracao',
                'data_entrega_divisao',
                'observacoes_logistica',
                'status_logistica',
                'relatorio_recebimento_et',
                'responsavel_divisao',
                'responsavel_et',
                'calibracao_id',
                'contrato_servico_id',
                'laboratorio_id',
                'logistica_et_id',
                'lote_id',
                'solicitacao_id',
                'transporte_id',
            ]);
        });
    }
};

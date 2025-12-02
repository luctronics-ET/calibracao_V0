<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela locais
        Schema::create('locais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo')->nullable(); // laboratorio, divisao, transporte, almoxarifado, etc.
            $table->string('referencia')->nullable(); // código interno
            $table->text('descricao')->nullable();
            $table->string('contato')->nullable();
            $table->text('endereco')->nullable();
            $table->timestamps();

            $table->index('nome');
        });

        // Tabela solicitacoes
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->id();
            $table->string('solicitante')->nullable();
            $table->string('tipo_servico')->nullable();
            $table->date('data_solicitacao')->nullable();
            $table->text('descricao')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        // Tabela transportes
        Schema::create('transportes', function (Blueprint $table) {
            $table->id();
            $table->string('transportadora')->nullable();
            $table->string('motorista')->nullable();
            $table->string('documento_transporte')->nullable(); // CTE, nota, referência
            $table->string('veiculo')->nullable();
            $table->string('contato')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('transportadora');
        });

        // Tabela padroes
        Schema::create('padroes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('modelo')->nullable();
            $table->string('fabricante')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('rbc_codigo_laboratorio')->nullable();
            $table->date('validade_certificado')->nullable();
            $table->string('arquivo_certificado_pdf')->nullable();
            $table->string('arquivo_sha256')->nullable();
            $table->timestamps();
        });

        // Tabela equipamento_padroes (relacionamento)
        Schema::create('equipamento_padroes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->foreignId('padrao_id')->constrained('padroes')->onDelete('cascade');
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('equipamento_id');
        });

        // Tabela equipamento_documentos
        Schema::create('equipamento_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->string('tipo_documento');
            $table->string('arquivo_path');
            $table->string('arquivo_sha256')->nullable();
            $table->string('doc_versao')->nullable();
            $table->date('doc_data_emissao')->nullable();
            $table->date('doc_data_revisao')->nullable();
            $table->string('doc_emissor')->nullable();
            $table->string('doc_revisador')->nullable();
            $table->string('doc_status')->nullable();
            $table->string('doc_referencia_interna')->nullable();
            $table->string('doc_vinculo_normativo')->nullable();
            $table->date('data_upload')->nullable();
            $table->timestamps();

            $table->index('equipamento_id');
        });

        // Tabela manutencoes
        Schema::create('manutencoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->string('tipo')->nullable();
            $table->text('descricao')->nullable();
            $table->date('data_manutencao')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('arquivo_relatorio_pdf')->nullable();
            $table->string('arquivo_sha256')->nullable();
            $table->timestamps();

            $table->index('equipamento_id');
        });

        // Tabela condicoes_ambientais
        Schema::create('condicoes_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->date('data_registro')->nullable();
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->decimal('umidade', 5, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });

        // Tabela auditoria
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->string('usuario')->nullable();
            $table->string('acao')->nullable();
            $table->string('entidade')->nullable();
            $table->unsignedBigInteger('entidade_id')->nullable();
            $table->dateTime('data_evento')->nullable();
            $table->text('detalhes')->nullable();
            $table->timestamps();
        });

        // Tabela cronograma_estagios
        Schema::create('cronograma_estagios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->string('nome_estagio');
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->unsignedBigInteger('responsavel_id')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('equipamento_id');
        });

        // Tabela lote_equipamentos
        Schema::create('lote_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes_envio')->onDelete('cascade');
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('lote_id');
            $table->index('equipamento_id');
        });

        // Tabela logistica_et
        Schema::create('logistica_et', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->nullable()->constrained('lotes_envio')->onDelete('set null');
            $table->foreignId('equipamento_id')->nullable()->constrained('equipamentos')->onDelete('set null');
            $table->foreignId('calibracao_id')->nullable()->constrained('calibracoes')->onDelete('set null');
            $table->foreignId('solicitacao_id')->nullable()->constrained('solicitacoes')->onDelete('set null');
            $table->foreignId('transporte_id')->nullable()->constrained('transportes')->onDelete('set null');
            $table->date('data_recebimento_et')->nullable();
            $table->text('relatorio_recebimento_et')->nullable();
            $table->unsignedBigInteger('responsavel_et')->nullable();
            $table->date('data_recebimento_transporte')->nullable();
            $table->text('relatorio_recebimento_transporte')->nullable();
            $table->date('data_recebimento_concluido_et')->nullable();
            $table->text('relatorio_recebimento_concluido_et')->nullable();
            $table->date('data_recebimento_divisao')->nullable();
            $table->text('relatorio_recebimento_divisao')->nullable();
            $table->unsignedBigInteger('responsavel_divisao')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('lote_id');
            $table->index('equipamento_id');
        });

        // Tabela logistica_eventos
        Schema::create('logistica_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->nullable()->constrained('lotes_envio')->onDelete('set null');
            $table->foreignId('equipamento_id')->nullable()->constrained('equipamentos')->onDelete('set null');
            $table->foreignId('calibracao_id')->nullable()->constrained('calibracoes')->onDelete('set null');
            $table->string('tipo_evento'); // envio_transporte, recebimento_transporte, recebimento_et, etc.
            $table->date('data_evento')->nullable();
            $table->unsignedBigInteger('responsavel_id')->nullable();
            $table->foreignId('transporte_id')->nullable()->constrained('transportes')->onDelete('set null');
            $table->text('relatorio')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('lote_id');
            $table->index('equipamento_id');
            $table->index('calibracao_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logistica_eventos');
        Schema::dropIfExists('logistica_et');
        Schema::dropIfExists('lote_equipamentos');
        Schema::dropIfExists('cronograma_estagios');
        Schema::dropIfExists('auditoria');
        Schema::dropIfExists('condicoes_ambientais');
        Schema::dropIfExists('manutencoes');
        Schema::dropIfExists('equipamento_documentos');
        Schema::dropIfExists('equipamento_padroes');
        Schema::dropIfExists('padroes');
        Schema::dropIfExists('transportes');
        Schema::dropIfExists('solicitacoes');
        Schema::dropIfExists('locais');
    }
};

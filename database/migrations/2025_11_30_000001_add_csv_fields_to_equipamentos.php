<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            // Campos do CSV
            $table->string('classe')->nullable()->after('tipo'); // ELE, MEC, etc
            $table->text('especificacoes')->nullable()->after('descricao');
            $table->string('patrimonio')->nullable()->after('codigo_interno');
            $table->string('status')->nullable()->after('status_calibracao'); // DESCALIBRADO, CALIBRADO, etc
            $table->string('setor')->nullable()->after('divisao_origem');

            // Campos metrológicos adicionais
            $table->decimal('altura', 10, 2)->nullable()->after('especificacoes');
            $table->decimal('largura', 10, 2)->nullable()->after('altura');
            $table->decimal('comprimento', 10, 2)->nullable()->after('largura');
            $table->string('tensao')->nullable()->after('comprimento');
            $table->string('potencia')->nullable()->after('tensao');

            // Documentação
            $table->string('manual_pdf')->nullable()->after('foto');
            $table->string('link_fabricante')->nullable()->after('manual_pdf');
            $table->text('instrucao_uso')->nullable()->after('link_fabricante');
            $table->text('instrucao_operacao')->nullable()->after('instrucao_uso');
            $table->text('instrucao_seguranca')->nullable()->after('instrucao_operacao');

            // Campos metrológicos avançados
            $table->string('incerteza_nominal')->nullable()->after('resolucao');
            $table->string('categoria_metrologica')->nullable()->after('classe_metrologica');

            // Campos financeiros
            $table->decimal('valor_aquisicao', 10, 2)->nullable()->after('instrucao_seguranca');
            $table->date('data_aquisicao')->nullable()->after('valor_aquisicao');
            $table->decimal('custo_estimado', 10, 2)->nullable()->after('data_aquisicao');
            $table->string('responsavel')->nullable()->after('local_fisico_atual');

            // Matriz de Classificação IGP
            $table->tinyInteger('frequencia_uso')->nullable()->comment('1=baixa, 2=média, 3=alta');
            $table->tinyInteger('necessidade_critica')->nullable()->comment('1=baixa, 2=média, 3=alta');
            $table->tinyInteger('abundancia')->nullable()->comment('1=único, 2=poucos, 3=muitos');
            $table->tinyInteger('criticidade_metrologica')->nullable()->comment('1=baixa, 2=média, 3=alta');
            $table->tinyInteger('custo_indisponibilidade')->nullable()->comment('1=baixo, 2=médio, 3=alto');
            $table->integer('igp')->nullable()->comment('Índice de Grau de Prioridade (calculado)');
            $table->enum('classificacao', ['alta', 'media', 'baixa'])->nullable()->comment('Classificação baseada no IGP');
        });
    }

    public function down(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            $table->dropColumn([
                'classe',
                'especificacoes',
                'patrimonio',
                'status',
                'setor',
                'altura',
                'largura',
                'comprimento',
                'tensao',
                'potencia',
                'manual_pdf',
                'link_fabricante',
                'instrucao_uso',
                'instrucao_operacao',
                'instrucao_seguranca',
                'incerteza_nominal',
                'categoria_metrologica',
                'valor_aquisicao',
                'data_aquisicao',
                'custo_estimado',
                'responsavel',
                'frequencia_uso',
                'necessidade_critica',
                'abundancia',
                'criticidade_metrologica',
                'custo_indisponibilidade',
                'igp',
                'classificacao',
            ]);
        });
    }
};

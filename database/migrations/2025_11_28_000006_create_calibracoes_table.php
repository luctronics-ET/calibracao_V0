<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalibracoesTable extends Migration {
    public function up() {
        Schema::create('calibracoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->foreignId('laboratorio_id')->nullable()->constrained('laboratorios')->onDelete('set null');
            $table->foreignId('lote_id')->nullable()->constrained('lotes_envio')->onDelete('set null');
            $table->date('data_envio')->nullable();
            $table->date('data_recebimento_lab')->nullable();
            $table->date('data_calibracao')->nullable();
            $table->date('data_retorno')->nullable();
            $table->date('data_aceitacao_et')->nullable();
            $table->string('status')->nullable();
            $table->string('resultado')->nullable();
            $table->string('certificado_num')->nullable();
            $table->string('arquivo_certificado')->nullable();
            $table->decimal('custo',12,2)->nullable();
            $table->string('responsavel_et')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('calibracoes');
    }
}

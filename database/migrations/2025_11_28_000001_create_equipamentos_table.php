<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipamentosTable extends Migration {
    public function up() {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('divisao_origem')->nullable();
            $table->string('tipo')->nullable();
            $table->string('categoria')->nullable();
            $table->string('fabricante')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->string('codigo_interno')->nullable();
            $table->text('descricao')->nullable();
            $table->string('local_fisico_atual')->nullable();
            $table->integer('ciclo_meses')->default(12);
            $table->string('criticidade')->nullable();
            $table->string('classe_metrologica')->nullable();
            $table->string('resolucao')->nullable();
            $table->string('faixa_medicao')->nullable();
            $table->string('mpe')->nullable();
            $table->string('norma_aplicavel')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('equipamentos');
    }
}

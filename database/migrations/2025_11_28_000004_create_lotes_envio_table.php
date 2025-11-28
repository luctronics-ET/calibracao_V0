<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesEnvioTable extends Migration {
    public function up() {
        Schema::create('lotes_envio', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_lote')->nullable();
            $table->date('data_envio')->nullable();
            $table->date('data_retorno')->nullable();
            $table->string('responsavel_envio')->nullable();
            $table->string('transportadora')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('lotes_envio');
    }
}

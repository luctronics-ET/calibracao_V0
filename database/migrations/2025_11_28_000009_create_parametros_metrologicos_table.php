<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametrosMetrologicosTable extends Migration {
    public function up() {
        Schema::create('parametros_metrologicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->string('descricao')->nullable();
            $table->string('valor_nominal')->nullable();
            $table->string('tolerancia')->nullable();
            $table->string('unidade')->nullable();
            $table->string('metodo')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('parametros_metrologicos');
    }
}

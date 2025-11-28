<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoriosTable extends Migration {
    public function up() {
        Schema::create('laboratorios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cnpj')->nullable();
            $table->boolean('acreditado')->default(false);
            $table->text('escopo')->nullable();
            $table->string('contato')->nullable();
            $table->text('endereco')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('laboratorios');
    }
}

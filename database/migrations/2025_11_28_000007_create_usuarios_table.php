<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration {
    public function up() {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('setor')->nullable();
            $table->string('permissao')->default('user');
            $table->string('email')->nullable();
            $table->string('senha_hash')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('usuarios');
    }
}

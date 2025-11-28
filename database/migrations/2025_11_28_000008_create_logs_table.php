<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration {
    public function up() {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->string('tabela')->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->string('acao')->nullable();
            $table->text('detalhe')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('logs');
    }
}

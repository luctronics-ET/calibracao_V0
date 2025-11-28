<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoteItensTable extends Migration {
    public function up() {
        Schema::create('lote_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes_envio')->onDelete('cascade');
            $table->foreignId('equipamento_id')->constrained('equipamentos')->onDelete('cascade');
            $table->string('situacao')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('lote_itens');
    }
}

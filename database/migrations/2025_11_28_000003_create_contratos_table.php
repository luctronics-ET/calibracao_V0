<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration {
    public function up() {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratorio_id')->constrained('laboratorios')->onDelete('cascade');
            $table->string('edital_num')->nullable();
            $table->date('vigencia_ini')->nullable();
            $table->date('vigencia_fim')->nullable();
            $table->decimal('preco_unitario',12,2)->nullable();
            $table->text('anexos')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('contratos');
    }
}

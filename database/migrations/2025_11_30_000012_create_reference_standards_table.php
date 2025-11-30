<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reference_standards', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descricao');
            $table->string('fabricante')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->date('data_calibracao')->nullable();
            $table->date('data_validade')->nullable();
            $table->string('certificado_rastreabilidade')->nullable();
            $table->text('cadeia_rastreabilidade')->nullable(); // JSON ou texto com histórico
            $table->decimal('incerteza', 12, 4)->nullable();
            $table->enum('status', ['ativo', 'vencido', 'manutencao', 'inativo'])->default('ativo');
            $table->timestamps();

            $table->index('codigo');
            $table->index('status');
            $table->index('data_validade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_standards');
    }
};

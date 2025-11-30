<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained()->onDelete('cascade');
            $table->string('parametro_nome'); // Pressão, Temperatura, Torque, etc
            $table->string('unidade'); // bar, °C, N.m, etc
            $table->decimal('valor_nominal', 12, 4)->nullable();
            $table->decimal('valor_medido', 12, 4);
            $table->decimal('incerteza', 12, 4)->nullable();
            $table->decimal('erro', 12, 4)->nullable();
            $table->string('padrao_referencia')->nullable();
            $table->enum('resultado', ['conforme', 'nao_conforme', 'restricao'])->default('conforme');
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('parametro_nome');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurement_parameters');
    }
};

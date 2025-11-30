<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calibracao_id')->constrained('calibracoes')->onDelete('cascade');
            $table->string('numero_certificado')->unique();
            $table->string('arquivo_pdf')->nullable();
            $table->date('data_emissao');
            $table->date('data_validade');
            $table->string('organismo_acreditacao')->nullable(); // RBC, INMETRO, etc
            $table->string('numero_acreditacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->boolean('valido')->default(true);
            $table->timestamps();

            $table->index('numero_certificado');
            $table->index('data_validade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

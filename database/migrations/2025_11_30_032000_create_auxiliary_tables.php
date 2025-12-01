<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de classes
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique(); // ELE, MEC, DIM
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        // Tabela de tipos de equipamento
        Schema::create('tipos_equipamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->nullable()->constrained('classes')->onDelete('cascade');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        // Tabela de setores
        Schema::create('setores', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('sigla')->nullable();
            $table->string('responsavel')->nullable();
            $table->timestamps();
        });

        // Tabela de localizações
        Schema::create('localizacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('andar')->nullable();
            $table->string('sala')->nullable();
            $table->string('predio')->nullable();
            $table->timestamps();
        });

        // Tabela de status de equipamentos
        Schema::create('status_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique(); // ativo, fora_uso, condenado, reserva
            $table->string('descricao')->nullable();
            $table->string('cor')->nullable(); // hex color for UI
            $table->timestamps();
        });

        // Popular com dados iniciais
        DB::table('classes')->insert([
            ['nome' => 'ELE', 'descricao' => 'Equipamento Elétrico'],
            ['nome' => 'MEC', 'descricao' => 'Equipamento Mecânico'],
            ['nome' => 'DIM', 'descricao' => 'Equipamento Dimensional'],
        ]);

        DB::table('status_equipamentos')->insert([
            ['nome' => 'ativo', 'descricao' => 'Equipamento em uso normal', 'cor' => '#10b981'],
            ['nome' => 'fora_uso', 'descricao' => 'Equipamento temporariamente fora de uso', 'cor' => '#f59e0b'],
            ['nome' => 'condenado', 'descricao' => 'Equipamento condenado para descarte', 'cor' => '#ef4444'],
            ['nome' => 'reserva', 'descricao' => 'Equipamento em estoque/reserva', 'cor' => '#3b82f6'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('status_equipamentos');
        Schema::dropIfExists('localizacoes');
        Schema::dropIfExists('setores');
        Schema::dropIfExists('tipos_equipamento');
        Schema::dropIfExists('classes');
    }
};

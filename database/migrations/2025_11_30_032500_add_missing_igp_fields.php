<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Verificar quais colunas já existem
        $existingColumns = collect(DB::select('PRAGMA table_info(equipamentos)'))
            ->pluck('name')
            ->toArray();

        Schema::table('equipamentos', function (Blueprint $table) use ($existingColumns) {
            // Adicionar apenas campos que NÃO existem

            // Metrologia
            if (!in_array('data_ultima_calibracao', $existingColumns)) {
                $table->date('data_ultima_calibracao')->nullable();
            }
            if (!in_array('periodicidade_meses', $existingColumns)) {
                $table->integer('periodicidade_meses')->default(12);
            }

            // Localização
            if (!in_array('localizacao', $existingColumns)) {
                $table->string('localizacao')->nullable();
            }

            // Documentação
            if (!in_array('comentarios', $existingColumns)) {
                $table->text('comentarios')->nullable();
            }

            // Certificação
            if (!in_array('certificado_pdf', $existingColumns)) {
                $table->string('certificado_pdf')->nullable();
            }
            if (!in_array('certificado_status', $existingColumns)) {
                $table->string('certificado_status')->nullable()->comment('valido, vencido, pendente');
            }
            if (!in_array('local_calibracao', $existingColumns)) {
                $table->string('local_calibracao')->nullable();
            }

            // IGP - classificacao_igp (classificacao já existe)
            if (!in_array('classificacao_igp', $existingColumns)) {
                $table->string('classificacao_igp')->nullable()->comment('baixa, media, alta');
            }
        });
    }

    public function down(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            $table->dropColumn([
                'data_ultima_calibracao',
                'periodicidade_meses',
                'localizacao',
                'comentarios',
                'certificado_pdf',
                'certificado_status',
                'local_calibracao',
                'classificacao_igp',
            ]);
        });
    }
};

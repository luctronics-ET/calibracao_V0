<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixDuplicateFieldsCommand extends Command
{
    protected $signature = 'db:fix-duplicate-fields';
    protected $description = 'Copia dados dos campos sem prefixo para campos com prefixo equipamento_';

    public function handle()
    {
        $this->info('🔧 Corrigindo campos duplicados...');

        // Mapear campos sem prefixo para campos com prefixo
        $mapping = [
            'categoria_metrologica' => 'categoria_metrologica', // Mantém igual
            'tipo' => 'equipamento_tipo',
            'fabricante' => 'equipamento_fabricante',
            'modelo' => 'equipamento_modelo',
            'codigo_interno' => 'equipamento_codigo_interno',
            'resolucao' => 'equipamento_resolucao',
            'data_ultima_calibracao' => 'equipamento_data_ultima_calibracao',
            'periodicidade_meses' => 'equipamento_periodicidade_meses',
            'localizacao' => 'equipamento_localizacao',
            'setor' => 'equipamento_setor',
            'comentarios' => 'equipamento_comentarios',
            'custo_estimado' => 'equipamento_custo_estimado',
            'certificado_pdf' => 'equipamento_certificado_pdf',
            'certificado_status' => 'equipamento_certificado_status',
            'local_calibracao' => 'equipamento_local_calibracao',
        ];

        $count = 0;

        DB::beginTransaction();

        try {
            // Para cada equipamento, copiar dados
            $equipamentos = DB::table('equipamentos')->get();

            foreach ($equipamentos as $eq) {
                $updates = [];

                foreach ($mapping as $old_field => $new_field) {
                    // Se o campo antigo tem valor e o novo está vazio, copiar
                    if (!empty($eq->$old_field) && empty($eq->$new_field)) {
                        $updates[$new_field] = $eq->$old_field;
                    }
                }

                if (!empty($updates)) {
                    DB::table('equipamentos')
                        ->where('id', $eq->id)
                        ->update($updates);
                    $count++;
                }
            }

            DB::commit();

            $this->info("✅ Corrigidos {$count} equipamentos");

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Erro: " . $e->getMessage());
            return 1;
        }
    }
}

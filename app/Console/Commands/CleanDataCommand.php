<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipamento;

class CleanDataCommand extends Command
{
    protected $signature = 'data:clean';
    protected $description = 'Limpa caracteres especiais e quebras de linha dos dados';

    public function handle()
    {
        $this->info('Limpando dados...');

        $cleaned = 0;
        $equipamentos = Equipamento::all();

        foreach ($equipamentos as $eq) {
            $changed = false;

            // Limpar modelo
            if ($eq->equipamento_modelo) {
                $original = $eq->equipamento_modelo;
                $clean = $this->cleanString($original);
                if ($clean !== $original) {
                    $eq->equipamento_modelo = $clean;
                    $changed = true;
                }
            }

            // Limpar serial
            if ($eq->equipamento_serial) {
                $original = $eq->equipamento_serial;
                $clean = $this->cleanString($original);
                if ($clean !== $original) {
                    $eq->equipamento_serial = $clean;
                    $changed = true;
                }
            }

            // Limpar tipo
            if ($eq->equipamento_tipo) {
                $original = $eq->equipamento_tipo;
                $clean = $this->cleanString($original);
                if ($clean !== $original) {
                    $eq->equipamento_tipo = $clean;
                    $changed = true;
                }
            }

            // Limpar fabricante
            if ($eq->equipamento_fabricante) {
                $original = $eq->equipamento_fabricante;
                $clean = $this->cleanString($original);
                if ($clean !== $original) {
                    $eq->equipamento_fabricante = $clean;
                    $changed = true;
                }
            }

            if ($changed) {
                $eq->save();
                $cleaned++;
            }
        }

        $this->info("Limpeza concluída! $cleaned equipamentos atualizados.");

        return 0;
    }

    private function cleanString($str)
    {
        if (!$str) return $str;

        // Remover quebras de linha
        $str = str_replace(["\r\n", "\r", "\n"], ' ', $str);

        // Substituir múltiplos espaços por um único
        $str = preg_replace('/\s+/', ' ', $str);

        // Remover caracteres de controle
        $str = preg_replace('/[\x00-\x1F\x7F]/u', '', $str);

        // Substituir travessão unicode por hífen comum
        $str = str_replace(['–', '—', '―'], '-', $str);

        // Trim
        $str = trim($str);

        return $str;
    }
}

<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Equipamento;
use App\Models\Calibracao;
use App\Models\Laboratorio;

echo "📊 DADOS IMPORTADOS\n";
echo "==================\n\n";

echo "Total de Equipamentos: " . Equipamento::count() . "\n";
echo "Total de Calibrações: " . Calibracao::count() . "\n";
echo "Total de Laboratórios: " . Laboratorio::count() . "\n\n";

echo "📦 Primeiros 5 Equipamentos:\n";
echo "----------------------------\n";
Equipamento::limit(5)->get()->each(function ($eq) {
    echo "• {$eq->equipamento_codigo_interno} - {$eq->equipamento_tipo} - {$eq->equipamento_fabricante} {$eq->equipamento_modelo}\n";
    echo "  Setor: {$eq->equipamento_setor} | Status: {$eq->equipamento_certificado_status}\n\n";
});

echo "🏢 Laboratórios:\n";
echo "----------------\n";
Laboratorio::all()->each(function ($lab) {
    echo "• {$lab->nome}\n";
});

echo "\n✅ Importação verificada com sucesso!\n";

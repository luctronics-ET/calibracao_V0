<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Equipamento;

echo "Verificando dados importados...\n\n";

$eq = Equipamento::find(2);
if ($eq) {
    echo "Equipamento ID 2:\n";
    $attrs = $eq->getAttributes();
    foreach ($attrs as $k => $v) {
        if (!empty($v) && !in_array($k, ['id', 'created_at', 'updated_at'])) {
            echo "  $k: " . substr($v, 0, 80) . "\n";
        }
    }
} else {
    echo "Equipamento não encontrado\n";
}

echo "\n\nTotal de equipamentos com dados:\n";
$count = Equipamento::whereNotNull('categoria_metrologica')->count();
echo "Com categoria_metrologica: $count\n";

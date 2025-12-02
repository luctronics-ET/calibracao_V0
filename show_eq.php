<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$eq = DB::table('equipamentos')->where('id', 2)->first();

echo "Campos preenchidos no equipamento ID 2:\n";
echo str_repeat('=', 60) . "\n";

foreach ($eq as $key => $val) {
    if (!empty($val) && !in_array($key, ['id', 'created_at', 'updated_at'])) {
        echo sprintf("%-40s: %s\n", $key, substr($val, 0, 50));
    }
}

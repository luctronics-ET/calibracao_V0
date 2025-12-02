<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== ANÁLISE DO BANCO DE DADOS ===\n\n";

// Verificar estrutura da tabela equipamentos
echo "ESTRUTURA DA TABELA EQUIPAMENTOS:\n";
echo str_repeat('=', 80) . "\n";
$columns = DB::select("PRAGMA table_info(equipamentos)");
$equipFields = [];
foreach ($columns as $col) {
    $equipFields[] = $col->name;
    echo sprintf("%-40s %s\n", $col->name, $col->type);
}
echo "\nTotal de colunas: " . count($columns) . "\n\n";

// Verificar estrutura da tabela calibracoes
echo "ESTRUTURA DA TABELA CALIBRACOES:\n";
echo str_repeat('=', 80) . "\n";
$columns = DB::select("PRAGMA table_info(calibracoes)");
$calibFields = [];
foreach ($columns as $col) {
    $calibFields[] = $col->name;
    echo sprintf("%-40s %s\n", $col->name, $col->type);
}
echo "\nTotal de colunas: " . count($columns) . "\n\n";

// Análise de dados em equipamentos
echo "ANÁLISE DE PREENCHIMENTO - EQUIPAMENTOS:\n";
echo str_repeat('=', 80) . "\n";
$totalEquip = DB::table('equipamentos')->count();
echo "Total de equipamentos: $totalEquip\n\n";

// Campos importantes para verificar
$fieldsToCheck = [
    'equipamento_codigo_interno',
    'equipamento_tipo',
    'equipamento_fabricante',
    'equipamento_modelo',
    'equipamento_serial',
    'equipamento_setor',
    'equipamento_localizacao',
    'equipamento_status',
    'equipamento_certificado_status',
    'equipamento_data_ultima_calibracao',
    'proxima_calibracao_prevista',
    'equipamento_local_calibracao',
    'numero_ordem_servico',
    'laboratorio_id',
    'calibracao_id',
];

foreach ($fieldsToCheck as $field) {
    if (in_array($field, $equipFields)) {
        $filled = DB::table('equipamentos')->whereNotNull($field)->where($field, '!=', '')->count();
        $percentage = $totalEquip > 0 ? ($filled / $totalEquip * 100) : 0;
        echo sprintf("%-40s %4d/%d (%.1f%%)\n", $field, $filled, $totalEquip, $percentage);
    }
}

// Análise de dados em calibracoes
echo "\n\nANÁLISE DE PREENCHIMENTO - CALIBRACOES:\n";
echo str_repeat('=', 80) . "\n";
$totalCalib = DB::table('calibracoes')->count();
echo "Total de calibrações: $totalCalib\n\n";

$calibFieldsToCheck = [
    'equipamento_id',
    'laboratorio_id',
    'data_calibracao',
    'data_validade',
    'numero_certificado',
    'resultado',
    'certificado_pdf',
    'observacoes',
];

foreach ($calibFieldsToCheck as $field) {
    if (in_array($field, $calibFields)) {
        $filled = DB::table('calibracoes')->whereNotNull($field)->where($field, '!=', '')->count();
        $percentage = $totalCalib > 0 ? ($filled / $totalCalib * 100) : 0;
        echo sprintf("%-40s %4d/%d (%.1f%%)\n", $field, $filled, $totalCalib, $percentage);
    }
}

// Verificar relações
echo "\n\nVERIFICAÇÃO DE RELAÇÕES:\n";
echo str_repeat('=', 80) . "\n";

// Equipamentos com laboratorio_id
$equipWithLab = DB::table('equipamentos')->whereNotNull('laboratorio_id')->count();
echo "Equipamentos com laboratorio_id: $equipWithLab\n";

// Equipamentos com calibracao_id
$equipWithCalib = DB::table('equipamentos')->whereNotNull('calibracao_id')->count();
echo "Equipamentos com calibracao_id: $equipWithCalib\n";

// Calibrações com equipamento_id
$calibWithEquip = DB::table('calibracoes')->whereNotNull('equipamento_id')->count();
echo "Calibrações com equipamento_id: $calibWithEquip\n";

// Calibrações com laboratorio_id
$calibWithLab = DB::table('calibracoes')->whereNotNull('laboratorio_id')->count();
echo "Calibrações com laboratorio_id: $calibWithLab\n";

// Amostra de dados
echo "\n\nAMOSTRA DE 3 EQUIPAMENTOS:\n";
echo str_repeat('=', 80) . "\n";
$sample = DB::table('equipamentos')->limit(3)->get();
foreach ($sample as $eq) {
    echo "ID: {$eq->id}\n";
    echo "  Código: {$eq->equipamento_codigo_interno}\n";
    echo "  Tipo: {$eq->equipamento_tipo}\n";
    echo "  Setor: {$eq->equipamento_setor}\n";
    echo "  Localização: {$eq->equipamento_localizacao}\n";
    echo "  Status: {$eq->equipamento_status}\n";
    echo "  Status Calibração: {$eq->equipamento_certificado_status}\n";
    echo "  Lab ID: {$eq->laboratorio_id}\n";
    echo "  Calib ID: {$eq->calibracao_id}\n";
    echo "  Local Calibração: {$eq->equipamento_local_calibracao}\n";
    echo "\n";
}

echo "\nAMOSTRA DE 3 CALIBRAÇÕES:\n";
echo str_repeat('=', 80) . "\n";
$sample = DB::table('calibracoes')->limit(3)->get();
foreach ($sample as $cal) {
    echo "ID: {$cal->id}\n";
    echo "  Equipamento ID: {$cal->equipamento_id}\n";
    echo "  Laboratório ID: {$cal->laboratorio_id}\n";
    echo "  Data: {$cal->data_calibracao}\n";
    echo "  Certificado: " . ($cal->certificado_num ?? 'N/A') . "\n";
    echo "  Resultado: {$cal->resultado}\n";
    echo "\n";
}

echo "\nLABORATÓRIOS CADASTRADOS:\n";
echo str_repeat('=', 80) . "\n";
$labs = DB::table('laboratorios')->get(['id', 'nome']);
foreach ($labs as $lab) {
    echo "ID {$lab->id}: {$lab->nome}\n";
}

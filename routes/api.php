<?php
// routes/api.php - API endpoints
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EquipamentoController;
use App\Http\Controllers\Api\CalibracoesController;
use App\Http\Controllers\Api\LotesController;
use App\Http\Controllers\Api\LaboratorioController;
use App\Http\Controllers\Api\LocalController;
use App\Http\Controllers\Api\TransporteController;
use App\Http\Controllers\Api\PadraoController;

// Equipamentos
Route::apiResource('equipamentos', EquipamentoController::class);
Route::post('/equipamentos/{id}/recalcular-igp', [EquipamentoController::class, 'recalcularIGP']);
Route::post('/equipamentos/{id}/upload-foto', [EquipamentoController::class, 'uploadFoto']);
Route::post('/equipamentos/{id}/upload-pdf', [EquipamentoController::class, 'uploadPdf']);

// Calibrações
Route::apiResource('calibracoes', CalibracoesController::class);
Route::post('/calibracoes/{id}/upload-certificado', [CalibracoesController::class, 'uploadCertificado']);

// Lotes
Route::apiResource('lotes', LotesController::class);

// Laboratórios
Route::apiResource('laboratorios', LaboratorioController::class);

// Locais
Route::apiResource('locais', LocalController::class);

// Transportes
Route::apiResource('transportes', TransporteController::class);

// Padrões
Route::apiResource('padroes', PadraoController::class);

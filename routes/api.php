<?php
// routes/api.php - example API endpoints
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EquipamentoController;

Route::get('/equipamentos', [EquipamentoController::class, 'index']);
Route::get('/equipamentos/{id}', [EquipamentoController::class, 'show']);

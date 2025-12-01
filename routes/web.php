<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\CalibracaoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VueAppController;

// Vue SPA - Nova Interface IGP
Route::get('/vue/{any?}', [VueAppController::class, 'index'])
    ->where('any', '.*')
    ->name('vue.app');

// Dashboard Original (Blade)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Resource Routes
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('calibracoes', CalibracaoController::class);
Route::resource('lotes', LoteController::class);
Route::resource('laboratorios', LaboratorioController::class);

// Certificados
Route::resource('certificates', CertificateController::class);
Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])
    ->name('certificates.download');

// Relatórios
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/vencimentos', [ReportController::class, 'vencimentos'])->name('vencimentos');
    Route::get('/historico', [ReportController::class, 'historico'])->name('historico');
    Route::get('/custos', [ReportController::class, 'custos'])->name('custos');
    Route::get('/igp', [ReportController::class, 'igp'])->name('igp');
    Route::get('/certificados', [ReportController::class, 'certificados'])->name('certificados');
});

// PDF Routes
Route::get('calibracoes/{calibracao}/certificado', [CalibracaoController::class, 'downloadCertificado'])->name('calibracoes.certificado');
Route::get('lotes/{lote}/pdf', [LoteController::class, 'downloadPdf'])->name('lotes.pdf');
Route::get('equipamentos/{equipamento}/historico', [EquipamentoController::class, 'downloadHistorico'])->name('equipamentos.historico');

// Export Routes
Route::get('equipamentos-export', [EquipamentoController::class, 'export'])->name('equipamentos.export');
Route::get('calibracoes-export', [CalibracaoController::class, 'export'])->name('calibracoes.export');
Route::get('lotes-export', [LoteController::class, 'export'])->name('lotes.export');

// Logs Routes
Route::get('logs', [LogController::class, 'index'])->name('logs.index');
Route::get('logs/{log}', [LogController::class, 'show'])->name('logs.show');

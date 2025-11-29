<?php
// routes/web.php - basic routes placeholder
use Illuminate\Support\Facades\Route;
use App\Models\Equipamento;
use App\Models\Calibracao;
use App\Models\LoteEnvio;
use App\Models\Laboratorio;

// Dashboard
Route::get('/', function () {
    return view('welcome', [
        'totalEquipamentos' => Equipamento::count(),
        'calibracoesAtivas' => Calibracao::whereIn('status', ['pendente', 'em_processo'])->count(),
        'lotesAndamento' => LoteEnvio::where('status', 'enviado')->count(),
        'totalLaboratorios' => Laboratorio::where('ativo', true)->count(),
    ]);
});

// Equipamentos
Route::get('/equipamentos', function () {
    return view('equipamentos.index', [
        'equipamentos' => Equipamento::orderBy('created_at', 'desc')->get()
    ]);
});

// Calibrações
Route::get('/calibracoes', function () {
    return view('calibracoes.index', [
        'calibracoes' => Calibracao::with(['equipamento', 'laboratorio'])
            ->orderBy('created_at', 'desc')
            ->get()
    ]);
});

// Lotes
Route::get('/lotes', function () {
    return view('lotes.index', [
        'lotes' => LoteEnvio::with(['laboratorio', 'itens'])
            ->orderBy('created_at', 'desc')
            ->get()
    ]);
});

// Laboratórios
Route::get('/laboratorios', function () {
    return view('laboratorios.index', [
        'laboratorios' => Laboratorio::orderBy('nome')->get()
    ]);
});

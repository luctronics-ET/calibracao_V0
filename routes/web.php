<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\CalibracaoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\LogController;
use App\Models\Equipamento;
use App\Models\Calibracao;
use App\Models\LoteEnvio;
use App\Models\Laboratorio;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

// Dashboard
Route::get('/', function () {
    $totalEquipamentos = Equipamento::count();
    $totalLaboratorios = Laboratorio::count();
    $lotesAndamento = LoteEnvio::whereIn('status', ['preparacao', 'enviado', 'em_calibracao'])->count();
    $calibracoesAtivas = Calibracao::count();

    $lastByEquip = Calibracao::select('equipamento_id', DB::raw('MAX(COALESCE(data_calibracao, data_retorno)) as last_calibracao'))
        ->groupBy('equipamento_id')
        ->pluck('last_calibracao', 'equipamento_id');

    $hoje = Carbon::today();
    $diasJanela = 30;
    $ate = $hoje->copy()->addDays($diasJanela);

    $vencidos = 0;
    $proximos = 0;
    $semCalibracao = 0;
    $porCriticidade = [
        'critica' => 0,
        'alta' => 0,
        'media' => 0,
        'baixa' => 0,
        'indefinida' => 0,
    ];

    Equipamento::select('id', 'ciclo_meses', 'criticidade')->chunk(500, function ($chunk) use (&$vencidos, &$proximos, &$semCalibracao, &$porCriticidade, $lastByEquip, $hoje, $ate) {
        foreach ($chunk as $eq) {
            $crit = $eq->criticidade ?: 'indefinida';
            if (!array_key_exists($crit, $porCriticidade)) $crit = 'indefinida';
            $porCriticidade[$crit]++;

            $last = $lastByEquip[$eq->id] ?? null;
            if (!$last) {
                $semCalibracao++;
                continue;
            }
            try {
                $validade = Carbon::parse($last)->addMonths((int)($eq->ciclo_meses ?: 12));
                if ($validade->lt($hoje)) {
                    $vencidos++;
                } elseif ($validade->between($hoje, $ate)) {
                    $proximos++;
                }
            } catch (\Exception $e) {
                $semCalibracao++;
            }
        }
    });

    $gastoMes = Calibracao::whereNotNull('custo')
        ->whereYear('data_calibracao', $hoje->year)
        ->whereMonth('data_calibracao', $hoje->month)
        ->sum('custo');
    $gastoAno = Calibracao::whereNotNull('custo')
        ->whereYear('data_calibracao', $hoje->year)
        ->sum('custo');

    return view('dashboard', [
        'totalEquipamentos' => $totalEquipamentos,
        'calibracoesAtivas' => $calibracoesAtivas,
        'lotesAndamento' => $lotesAndamento,
        'totalLaboratorios' => $totalLaboratorios,
        'vencidos' => $vencidos,
        'proximos' => $proximos,
        'semCalibracao' => $semCalibracao,
        'porCriticidade' => $porCriticidade,
        'gastoMes' => $gastoMes,
        'gastoAno' => $gastoAno,
        'janelaDias' => $diasJanela,
    ]);
})->name('dashboard');

// Resource Routes
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('calibracoes', CalibracaoController::class);
Route::resource('lotes', LoteController::class);
Route::resource('laboratorios', LaboratorioController::class);

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

<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the logs.
     */
    public function index(Request $request)
    {
        $tabela = $request->get('tabela');
        $acao = $request->get('acao');
        $from = $request->get('from');
        $to = $request->get('to');

        $logs = Log::with('usuario')
            ->when($tabela, function ($q) use ($tabela) {
                $q->where('tabela', $tabela);
            })
            ->when($acao, function ($q) use ($acao) {
                $q->where('acao', $acao);
            })
            ->when($from, function ($q) use ($from) {
                $q->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($q) use ($to) {
                $q->whereDate('created_at', '<=', $to);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50)
            ->appends($request->query());

        return view('logs.index', compact('logs'));
    }

    /**
     * Display the specified log.
     */
    public function show(Log $log)
    {
        $log->load('usuario');
        return view('logs.show', compact('log'));
    }
}

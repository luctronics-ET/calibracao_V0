<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index()
    {
        $lotes = Lote::with(['laboratorio', 'contrato'])->paginate(20);
        return view('lotes.index', compact('lotes'));
    }

    public function create()
    {
        return view('lotes.create');
    }

    public function store(Request $request)
    {
        $lote = Lote::create($request->all());
        return redirect()->route('lotes.index');
    }

    public function show(Lote $lote)
    {
        return view('lotes.show', compact('lote'));
    }

    public function edit(Lote $lote)
    {
        return view('lotes.edit', compact('lote'));
    }

    public function update(Request $request, Lote $lote)
    {
        $lote->update($request->all());
        return redirect()->route('lotes.index');
    }

    public function destroy(Lote $lote)
    {
        $lote->delete();
        return redirect()->route('lotes.index');
    }

    public function downloadPdf(Lote $lote)
    {
        // Implementar download de PDF
        return response()->json(['message' => 'Download em desenvolvimento']);
    }
}

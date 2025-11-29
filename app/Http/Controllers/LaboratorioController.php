<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use App\Http\Requests\StoreLaboratorioRequest;
use App\Http\Requests\UpdateLaboratorioRequest;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $laboratorios = Laboratorio::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qb) use ($q) {
                    $qb->where('nome', 'like', "%$q%")
                        ->orWhere('cnpj', 'like', "%$q%");
                });
            })
            ->orderBy('nome')
            ->paginate(20)
            ->appends($request->query());
        return view('laboratorios.index', compact('laboratorios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laboratorios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaboratorioRequest $request)
    {
        $validated = $request->validated();

        Laboratorio::create($validated);

        return redirect()->route('laboratorios.index')
            ->with('success', 'Laboratório criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laboratorio $laboratorio)
    {
        $laboratorio->load(['contratos']);
        return view('laboratorios.show', compact('laboratorio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laboratorio $laboratorio)
    {
        return view('laboratorios.edit', compact('laboratorio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaboratorioRequest $request, Laboratorio $laboratorio)
    {
        $validated = $request->validated();

        $laboratorio->update($validated);

        return redirect()->route('laboratorios.index')
            ->with('success', 'Laboratório atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratorio $laboratorio)
    {
        $laboratorio->delete();

        return redirect()->route('laboratorios.index')
            ->with('success', 'Laboratório excluído com sucesso!');
    }
}

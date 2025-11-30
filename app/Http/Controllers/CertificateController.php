<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Calibracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('calibracao.equipamento')
            ->latest()
            ->paginate(20);

        return view('certificates.index', compact('certificates'));
    }

    public function create(Calibracao $calibracao = null)
    {
        $calibracoes = Calibracao::with('equipamento')->get();

        return view('certificates.create', compact('calibracoes', 'calibracao'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'calibracao_id' => 'required|exists:calibracoes,id',
            'numero_certificado' => 'required|unique:certificates',
            'arquivo_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'data_emissao' => 'required|date',
            'data_validade' => 'required|date|after:data_emissao',
            'organismo_acreditacao' => 'nullable|string|max:255',
            'numero_acreditacao' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        if ($request->hasFile('arquivo_pdf')) {
            $validated['arquivo_pdf'] = $request->file('arquivo_pdf')
                ->store('certificates', 'public');
        }

        $certificate = Certificate::create($validated);

        return redirect()->route('certificates.show', $certificate)
            ->with('success', 'Certificado cadastrado com sucesso!');
    }

    public function show(Certificate $certificate)
    {
        $certificate->load(['calibracao.equipamento', 'measurementParameters']);

        return view('certificates.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        $calibracoes = Calibracao::with('equipamento')->get();

        return view('certificates.edit', compact('certificate', 'calibracoes'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'calibracao_id' => 'required|exists:calibracoes,id',
            'numero_certificado' => 'required|unique:certificates,numero_certificado,' . $certificate->id,
            'arquivo_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'data_emissao' => 'required|date',
            'data_validade' => 'required|date|after:data_emissao',
            'organismo_acreditacao' => 'nullable|string|max:255',
            'numero_acreditacao' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'valido' => 'boolean',
        ]);

        if ($request->hasFile('arquivo_pdf')) {
            if ($certificate->arquivo_pdf) {
                Storage::disk('public')->delete($certificate->arquivo_pdf);
            }
            $validated['arquivo_pdf'] = $request->file('arquivo_pdf')
                ->store('certificates', 'public');
        }

        $certificate->update($validated);

        return redirect()->route('certificates.show', $certificate)
            ->with('success', 'Certificado atualizado com sucesso!');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->arquivo_pdf) {
            Storage::disk('public')->delete($certificate->arquivo_pdf);
        }

        $certificate->delete();

        return redirect()->route('certificates.index')
            ->with('success', 'Certificado excluído com sucesso!');
    }

    public function download(Certificate $certificate)
    {
        if (!$certificate->arquivo_pdf || !Storage::disk('public')->exists($certificate->arquivo_pdf)) {
            abort(404, 'Arquivo não encontrado');
        }

        return Storage::disk('public')->download(
            $certificate->arquivo_pdf,
            "certificado_{$certificate->numero_certificado}.pdf"
        );
    }
}

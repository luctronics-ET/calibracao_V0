@extends('layouts.app')

@section('title', 'Nova Calibração - CalibSys')

@section('page-title', 'Nova Calibração')

@section('breadcrumb')
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <i class="fas fa-home mr-2"></i>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <a href="{{ route('calibracoes.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">Calibrações</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nova</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
        Cadastrar Nova Calibração
    </h2>
</div>

<form action="{{ route('calibracoes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- Informações Principais -->
    <x-card title="Informações Principais" icon="fas fa-info-circle">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select
                label="Equipamento"
                name="equipamento_id"
                :options="$equipamentos->pluck('equipamento_tipo', 'id')->toArray()"
                :selected="old('equipamento_id')"
                :error="$errors->first('equipamento_id')"
                required
            />

            <x-select
                label="Laboratório"
                name="laboratorio_id"
                :options="$laboratorios->pluck('nome', 'id')->toArray()"
                :selected="old('laboratorio_id')"
                :error="$errors->first('laboratorio_id')"
                required
            />

            <x-input
                type="date"
                label="Data da Calibração"
                name="data_calibracao"
                :value="old('data_calibracao')"
                :error="$errors->first('data_calibracao')"
                required
            />

            <x-input
                label="Número do Certificado"
                name="numero_certificado"
                placeholder="Ex: CAL-2025-001"
                :value="old('numero_certificado')"
                :error="$errors->first('numero_certificado')"
            />
        </div>
    </x-card>

    <!-- Resultado da Calibração -->
    <x-card title="Resultado da Calibração" icon="fas fa-check-circle">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select
                label="Resultado"
                name="resultado"
                :options="[
                    'aprovado' => 'Aprovado',
                    'reprovado' => 'Reprovado',
                    'condicional' => 'Condicional',
                    'pendente' => 'Pendente'
                ]"
                :selected="old('resultado', 'pendente')"
                :error="$errors->first('resultado')"
                required
            />

            <x-input
                type="date"
                label="Próxima Calibração"
                name="proxima_calibracao"
                :value="old('proxima_calibracao')"
                :error="$errors->first('proxima_calibracao')"
            />

            <div class="md:col-span-2">
                <x-textarea
                    label="Observações"
                    name="observacoes"
                    rows="4"
                    placeholder="Observações sobre a calibração..."
                    :value="old('observacoes')"
                    :error="$errors->first('observacoes')"
                />
            </div>
        </div>
    </x-card>

    <!-- Documentos -->
    <x-card title="Documentos" icon="fas fa-file-pdf">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Certificado de Calibração (PDF)
                </label>
                <input
                    type="file"
                    name="certificado_pdf"
                    accept=".pdf"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @if($errors->has('certificado_pdf'))
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $errors->first('certificado_pdf') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Outros Anexos
                </label>
                <input
                    type="file"
                    name="anexos[]"
                    multiple
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2.5 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>
    </x-card>

    <!-- Botões de Ação -->
    <div class="flex items-center justify-end gap-3">
        <x-button variant="outline" icon="fas fa-times" :href="route('calibracoes.index')">
            Cancelar
        </x-button>

        <x-button variant="primary" type="submit" icon="fas fa-save">
            Salvar Calibração
        </x-button>
    </div>
</form>
@endsection

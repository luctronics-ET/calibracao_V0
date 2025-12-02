@extends('layouts.app')

@section('title', 'Editar Laboratório - CalibSys')

@section('page-title', 'Editar Laboratório')

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
                <a href="{{ route('laboratorios.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Laboratórios
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Editar</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-flask text-blue-600 mr-2"></i>
        Editar Laboratório
    </h2>
</div>

<form action="{{ route('laboratorios.update', $laboratorio->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <x-card title="Informações Básicas" icon="fas fa-info-circle">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nome -->
            <div class="md:col-span-2">
                <x-input
                    name="nome"
                    label="Nome do Laboratório"
                    :value="old('nome', $laboratorio->nome ?? '')"
                    placeholder="Nome completo do laboratório"
                    required
                />
            </div>

            <!-- CNPJ -->
            <x-input
                name="cnpj"
                label="CNPJ"
                :value="old('cnpj', $laboratorio->cnpj ?? '')"
                placeholder="00.000.000/0000-00"
            />

            <!-- Contato -->
            <x-input
                name="contato"
                label="Contato"
                :value="old('contato', $laboratorio->contato ?? '')"
                placeholder="Telefone ou email"
            />

            <!-- Acreditado -->
            <div class="md:col-span-2">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="acreditado"
                        value="1"
                        {{ old('acreditado', $laboratorio->acreditado ?? false) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    >
                    <div>
                        <span class="font-medium text-gray-900 dark:text-white">Laboratório Acreditado</span>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Marque se o laboratório possui acreditação (RBC, ISO 17025, etc.)</p>
                    </div>
                </label>
            </div>
        </div>
    </x-card>

    <x-card title="Endereço" icon="fas fa-map-marker-alt">
        <x-textarea
            name="endereco"
            label="Endereço Completo"
            :value="old('endereco', $laboratorio->endereco ?? '')"
            placeholder="Rua, número, bairro, cidade, estado, CEP..."
            rows="3"
        />
    </x-card>

    <x-card title="Escopo de Acreditação" icon="fas fa-clipboard-list">
        <x-textarea
            name="escopo"
            label="Escopo de Acreditação"
            :value="old('escopo', $laboratorio->escopo ?? '')"
            placeholder="Descreva o escopo de acreditação do laboratório (ex: Dimensional, Massa, Pressão, Temperatura, etc.)"
            rows="5"
            help="Liste os tipos de equipamentos ou grandezas que o laboratório pode calibrar"
        />
    </x-card>

    <!-- Botões de Ação -->
    <div class="flex gap-3 justify-end">
        <x-button variant="outline" type="button" onclick="window.history.back()">
            <i class="fas fa-times mr-2"></i>
            Cancelar
        </x-button>

        <x-button variant="primary" type="submit">
            <i class="fas fa-save mr-2"></i>
            Atualizar Laboratório
        </x-button>
    </div>
</form>

@endsection

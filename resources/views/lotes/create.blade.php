@extends('layouts.app')

@section('title', 'Novo Lote de Envio - CalibSys')

@section('page-title', 'Novo Lote')

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
                <a href="{{ route('lotes.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Lotes
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Novo</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-boxes text-blue-600 mr-2"></i>
        Cadastrar Novo Lote de Envio
    </h2>
</div>

<form action="{{ route('lotes.store') }}" method="POST" class="space-y-6">
    @csrf

    <x-card title="Informações do Lote" icon="fas fa-info-circle">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Código do Lote -->
            <x-input
                name="codigo_lote"
                label="Código do Lote"
                :value="old('codigo_lote')"
                placeholder="Ex: LT-2025-001"
            />

            <!-- Status -->
            <x-select
                name="status"
                label="Status"
                :options="[
                    'preparacao' => 'Em Preparação',
                    'enviado' => 'Enviado',
                    'em_calibracao' => 'Em Calibração',
                    'retornado' => 'Retornado',
                    'cancelado' => 'Cancelado'
                ]"
                :selected="old('status', 'preparacao')"
            />

            <!-- Data de Envio -->
            <x-input
                type="date"
                name="data_envio"
                label="Data de Envio"
                :value="old('data_envio')"
            />

            <!-- Data de Retorno -->
            <x-input
                type="date"
                name="data_retorno"
                label="Data de Retorno Prevista"
                :value="old('data_retorno')"
            />

            <!-- Responsável pelo Envio -->
            <x-input
                name="responsavel_envio"
                label="Responsável pelo Envio"
                :value="old('responsavel_envio')"
                placeholder="Nome do responsável"
            />

            <!-- Transportadora -->
            <x-input
                name="transportadora"
                label="Transportadora"
                :value="old('transportadora')"
                placeholder="Nome da transportadora"
            />
        </div>

        <!-- Observações -->
        <div class="mt-6">
            <x-textarea
                name="observacoes"
                label="Observações"
                :value="old('observacoes')"
                placeholder="Observações sobre o lote de envio..."
                rows="4"
            />
        </div>
    </x-card>

    <!-- Botões de Ação -->
    <div class="flex gap-3 justify-end">
        <x-button variant="outline" type="button" onclick="window.history.back()">
            <i class="fas fa-times mr-2"></i>
            Cancelar
        </x-button>

        <x-button variant="primary" type="submit">
            <i class="fas fa-save mr-2"></i>
            Salvar Lote
        </x-button>
    </div>
</form>

@endsection

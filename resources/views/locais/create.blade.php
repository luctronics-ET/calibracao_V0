@extends('layouts.app')
@section('title', 'Novo Local - CalibSys')
@section('content')

<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-home mr-2"></i>Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <a href="{{ route('locais.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Locais</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500">Novo</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-6">
    <h2 class="text-2xl font-bold"><i class="fas fa-plus-circle text-blue-600 mr-2"></i>Novo Local</h2>
</div>

<form action="{{ route('locais.store') }}" method="POST" class="space-y-6">
    @csrf

    <x-card title="Informações do Local" icon="fas fa-map-marker-alt">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Local *</label>
                <input type="text" name="nome" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('nome') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                <select name="tipo" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Selecione...</option>
                    <option value="laboratorio">Laboratório</option>
                    <option value="divisao">Divisão</option>
                    <option value="transporte">Transporte</option>
                    <option value="almoxarifado">Almoxarifado</option>
                    <option value="setor">Setor</option>
                    <option value="sala">Sala</option>
                    <option value="armario">Armário</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Referência/Código</label>
                <input type="text" name="referencia" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('referencia') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contato/Responsável</label>
                <input type="text" name="contato" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('contato') }}">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Endereço/Descrição</label>
                <textarea name="endereco" rows="2" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('endereco') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea name="observacoes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('observacoes') }}</textarea>
            </div>
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary" icon="fas fa-save">Salvar Local</x-button>
        <x-button type="button" variant="secondary" icon="fas fa-arrow-left" onclick="window.location='{{ route('locais.index') }}'">Cancelar</x-button>
    </div>
</form>
@endsection

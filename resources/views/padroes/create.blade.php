@extends('layouts.app')
@section('title', 'Novo Padrão RBC - CalibSys')
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
                <a href="{{ route('padroes.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Padrões RBC</a>
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
    <h2 class="text-2xl font-bold"><i class="fas fa-plus-circle text-blue-600 mr-2"></i>Novo Padrão de Medição RBC</h2>
</div>

<form action="{{ route('padroes.store') }}" method="POST" class="space-y-6">
    @csrf

    <x-card title="Identificação do Padrão" icon="fas fa-award">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Padrão *</label>
                <input type="text" name="nome" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('nome') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Modelo</label>
                <input type="text" name="modelo" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('modelo') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fabricante</label>
                <input type="text" name="fabricante" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('fabricante') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Número de Série</label>
                <input type="text" name="numero_serie" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('numero_serie') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Código do Laboratório RBC</label>
                <input type="text" name="rbc_codigo_laboratorio" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('rbc_codigo_laboratorio') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Número do Certificado</label>
                <input type="text" name="numero_certificado" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('numero_certificado') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Data de Emissão</label>
                <input type="date" name="data_emissao_certificado" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('data_emissao_certificado') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Validade do Certificado</label>
                <input type="date" name="validade_certificado" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('validade_certificado') }}">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Grandeza</label>
                <input type="text" name="grandeza" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('grandeza') }}" placeholder="Ex: Temperatura, Massa, Pressão">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea name="observacoes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('observacoes') }}</textarea>
            </div>
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary" icon="fas fa-save">Salvar Padrão</x-button>
        <x-button type="button" variant="secondary" icon="fas fa-arrow-left" onclick="window.location='{{ route('padroes.index') }}'">Cancelar</x-button>
    </div>
</form>
@endsection

@extends('layouts.app')
@section('title', 'Editar Transportadora - CalibSys')
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
                <a href="{{ route('transportes.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Transportes</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500">Editar #{{ $transporte->id }}</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-6">
    <h2 class="text-2xl font-bold"><i class="fas fa-edit text-blue-600 mr-2"></i>Editar Transportadora</h2>
</div>

<form action="{{ route('transportes.update', $transporte) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <x-card title="Dados da Transportadora" icon="fas fa-truck">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nome da Transportadora *</label>
                <input type="text" name="transportadora" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('transportadora', $transporte->transportadora) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Motorista</label>
                <input type="text" name="motorista" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('motorista', $transporte->motorista) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Veículo (Placa/Modelo)</label>
                <input type="text" name="veiculo" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('veiculo', $transporte->veiculo) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Documento de Transporte</label>
                <input type="text" name="documento_transporte" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('documento_transporte', $transporte->documento_transporte) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contato/Telefone</label>
                <input type="text" name="contato" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('contato', $transporte->contato) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('email', $transporte->email) }}">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea name="observacoes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('observacoes', $transporte->observacoes) }}</textarea>
            </div>
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary" icon="fas fa-save">Atualizar Transportadora</x-button>
        <x-button type="button" variant="secondary" icon="fas fa-arrow-left" onclick="window.location='{{ route('transportes.index') }}'">Cancelar</x-button>
    </div>
</form>
@endsection

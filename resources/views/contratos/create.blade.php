@extends('layouts.app')

@section('title', 'Novo Contrato - CalibSys')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-file-contract text-blue-600 mr-2"></i>
        Novo Contrato de Serviço
    </h2>
</div>

<form action="{{ route('contratos.store') }}" method="POST">
    @csrf
    <x-card title="Dados do Contrato" icon="fas fa-info-circle">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Laboratório</label>
                <select name="laboratorio_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    <option value="">Selecione...</option>
                    @foreach($laboratorios as $lab)
                        <option value="{{ $lab->id }}">{{ $lab->nome }}</option>
                    @endforeach
                </select>
            </div>

            <x-input name="numero_contrato" label="Número do Contrato" :value="old('numero_contrato')" required />
            <x-input type="number" step="0.01" name="valor_contrato" label="Valor do Contrato" :value="old('valor_contrato')" />
            <x-input type="date" name="data_inicio" label="Data de Início" :value="old('data_inicio')" />
            <x-input type="date" name="data_fim" label="Data de Término" :value="old('data_fim')" />

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descrição</label>
                <textarea name="descricao" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">{{ old('descricao') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observações</label>
                <textarea name="observacoes" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">{{ old('observacoes') }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <x-button type="submit" variant="primary" icon="fas fa-save">Salvar</x-button>
            <x-button variant="outline" icon="fas fa-times" :href="route('contratos.index')">Cancelar</x-button>
        </div>
    </x-card>
</form>
@endsection

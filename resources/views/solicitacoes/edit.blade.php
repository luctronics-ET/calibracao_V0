@extends('layouts.app')
@section('title', 'Editar Solicitação - CalibSys')
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
                <a href="{{ route('solicitacoes.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Solicitações</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500">Editar #{{ $solicitacao->id }}</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-6">
    <h2 class="text-2xl font-bold"><i class="fas fa-edit text-blue-600 mr-2"></i>Editar Solicitação #{{ $solicitacao->id }}</h2>
</div>

<form action="{{ route('solicitacoes.update', $solicitacao) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <x-card title="Informações da Solicitação" icon="fas fa-clipboard-list">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Solicitante *</label>
                <input type="text" name="solicitante" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('solicitante', $solicitacao->solicitante) }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Serviço</label>
                <select name="tipo_servico" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Selecione...</option>
                    <option value="calibracao" {{ old('tipo_servico', $solicitacao->tipo_servico) == 'calibracao' ? 'selected' : '' }}>Calibração</option>
                    <option value="manutencao" {{ old('tipo_servico', $solicitacao->tipo_servico) == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                    <option value="verificacao" {{ old('tipo_servico', $solicitacao->tipo_servico) == 'verificacao' ? 'selected' : '' }}>Verificação</option>
                    <option value="ajuste" {{ old('tipo_servico', $solicitacao->tipo_servico) == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Data Solicitação</label>
                <input type="date" name="data_solicitacao" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('data_solicitacao', $solicitacao->data_solicitacao ? $solicitacao->data_solicitacao->format('Y-m-d') : '') }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="pendente" {{ old('status', $solicitacao->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="em_andamento" {{ old('status', $solicitacao->status) == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="concluida" {{ old('status', $solicitacao->status) == 'concluida' ? 'selected' : '' }}>Concluída</option>
                    <option value="cancelada" {{ old('status', $solicitacao->status) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Observações</label>
                <textarea name="observacoes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('observacoes', $solicitacao->observacoes) }}</textarea>
            </div>
        </div>
    </x-card>

    <div class="flex gap-3">
        <x-button type="submit" variant="primary" icon="fas fa-save">Atualizar Solicitação</x-button>
        <x-button type="button" variant="secondary" icon="fas fa-arrow-left" onclick="window.location='{{ route('solicitacoes.index') }}'">Cancelar</x-button>
    </div>
</form>
@endsection

@extends('layouts.app')

@section('title', 'Detalhes do Contrato - CalibSys')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-file-contract text-blue-600 mr-2"></i>
        Detalhes do Contrato
    </h2>
    <div class="flex gap-2">
        <x-button variant="primary" icon="fas fa-edit" :href="route('contratos.edit', $contrato)">Editar</x-button>
        <x-button variant="outline" icon="fas fa-arrow-left" :href="route('contratos.index')">Voltar</x-button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <x-card title="Informações do Contrato" icon="fas fa-info-circle">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número do Contrato</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">{{ $contrato->numero_contrato }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Laboratório</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contrato->laboratorio->nome ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Início</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $contrato->data_inicio ? $contrato->data_inicio->format('d/m/Y') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Término</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $contrato->data_fim ? $contrato->data_fim->format('d/m/Y') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Valor do Contrato</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                        {{ $contrato->valor_contrato ? 'R$ ' . number_format($contrato->valor_contrato, 2, ',', '.') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-1">
                        @if($contrato->data_fim && $contrato->data_fim >= now())
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
                        @elseif($contrato->data_fim)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Vencido</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Indefinido</span>
                        @endif
                    </dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Descrição</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contrato->descricao ?? '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Observações</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contrato->observacoes ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <div>
        <x-card title="Informações do Sistema" icon="fas fa-cog">
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Criado em</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $contrato->created_at->format('d/m/Y H:i') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última atualização</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $contrato->updated_at->format('d/m/Y H:i') }}
                    </dd>
                </div>
            </dl>
        </x-card>
    </div>
</div>
@endsection

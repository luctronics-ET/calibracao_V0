@extends('layouts.app')

@section('title', 'Lote #' . $lote->id . ' - CalibSys')

@section('page-title', 'Detalhes do Lote')

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
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Detalhes</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-boxes text-blue-600 mr-2"></i>
        Lote #{{ $lote->id }}
        @php
            $statusColors = [
                'preparacao' => 'gray',
                'enviado' => 'yellow',
                'em_calibracao' => 'blue',
                'retornado' => 'green',
                'cancelado' => 'red'
            ];
            $statusLabels = [
                'preparacao' => 'Em Preparação',
                'enviado' => 'Enviado',
                'em_calibracao' => 'Em Calibração',
                'retornado' => 'Retornado',
                'cancelado' => 'Cancelado'
            ];
            $color = $statusColors[$lote->status] ?? 'gray';
            $label = $statusLabels[$lote->status] ?? $lote->status;
        @endphp
        <x-badge variant="{{ $color }}" class="ml-3">{{ $label }}</x-badge>
    </h2>

    <div class="flex gap-2">
        <x-button variant="primary" icon="fas fa-edit" :href="route('lotes.edit', $lote->id)">
            Editar
        </x-button>
        <x-button variant="outline" icon="fas fa-arrow-left" onclick="window.history.back()">
            Voltar
        </x-button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Coluna Principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Informações do Lote -->
        <x-card title="Informações do Lote" icon="fas fa-info-circle">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Código do Lote</p>
                    <p class="mt-1 text-base text-gray-900 dark:text-white font-semibold">
                        {{ $lote->codigo_lote ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                    <p class="mt-1">
                        <x-badge variant="{{ $color }}">{{ $label }}</x-badge>
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Envio</p>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        @if($lote->data_envio)
                            <i class="fas fa-calendar text-blue-600 mr-1"></i>
                            {{ \Carbon\Carbon::parse($lote->data_envio)->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">Não definida</span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Retorno</p>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        @if($lote->data_retorno)
                            <i class="fas fa-calendar text-green-600 mr-1"></i>
                            {{ \Carbon\Carbon::parse($lote->data_retorno)->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">Não definida</span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Responsável pelo Envio</p>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $lote->responsavel_envio ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Transportadora</p>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $lote->transportadora ?? '-' }}
                    </p>
                </div>
            </div>
        </x-card>

        <!-- Observações -->
        @if($lote->observacoes)
        <x-card title="Observações" icon="fas fa-comment">
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $lote->observacoes }}</p>
        </x-card>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Timestamps -->
        <x-card title="Informações do Sistema" icon="fas fa-clock">
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Criado em</p>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $lote->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Última atualização</p>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $lote->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </x-card>

        <!-- Ações Rápidas -->
        <x-card title="Ações" icon="fas fa-bolt">
            <div class="space-y-2">
                <x-button variant="primary" icon="fas fa-edit" :href="route('lotes.edit', $lote->id)" class="w-full justify-center">
                    Editar Lote
                </x-button>

                <form action="{{ route('lotes.destroy', $lote->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir este lote?')">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" icon="fas fa-trash" type="submit" class="w-full justify-center">
                        Excluir Lote
                    </x-button>
                </form>
            </div>
        </x-card>
    </div>
</div>

@endsection

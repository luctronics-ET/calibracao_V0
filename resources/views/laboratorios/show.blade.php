@extends('layouts.app')

@section('title', $laboratorio->nome . ' - CalibSys')

@section('page-title', 'Detalhes do Laboratório')

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
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Detalhes</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-flask text-blue-600 mr-2"></i>
        {{ $laboratorio->nome }}
        @if($laboratorio->acreditado)
            <x-badge variant="success" class="ml-3">
                <i class="fas fa-certificate mr-1"></i>Acreditado
            </x-badge>
        @endif
    </h2>

    <div class="flex gap-2">
        <x-button variant="primary" icon="fas fa-edit" :href="route('laboratorios.edit', $laboratorio->id)">
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
        <!-- Informações Básicas -->
        <x-card title="Informações do Laboratório" icon="fas fa-info-circle">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</p>
                    <p class="mt-1 text-lg text-gray-900 dark:text-white font-semibold">
                        {{ $laboratorio->nome }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">CNPJ</p>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        {{ $laboratorio->cnpj ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Contato</p>
                    <p class="mt-1 text-base text-gray-900 dark:text-white">
                        @if($laboratorio->contato)
                            <i class="fas fa-phone text-blue-600 mr-1"></i>
                            {{ $laboratorio->contato }}
                        @else
                            <span class="text-gray-400">Não informado</span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Acreditação</p>
                    <p class="mt-1">
                        @if($laboratorio->acreditado)
                            <x-badge variant="success">
                                <i class="fas fa-check-circle mr-1"></i>Acreditado
                            </x-badge>
                        @else
                            <x-badge variant="default">
                                <i class="fas fa-minus-circle mr-1"></i>Não Acreditado
                            </x-badge>
                        @endif
                    </p>
                </div>
            </div>
        </x-card>

        <!-- Endereço -->
        @if($laboratorio->endereco)
        <x-card title="Endereço" icon="fas fa-map-marker-alt">
            <p class="text-gray-700 dark:text-gray-300">
                <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                {{ $laboratorio->endereco }}
            </p>
        </x-card>
        @endif

        <!-- Escopo de Acreditação -->
        @if($laboratorio->escopo)
        <x-card title="Escopo de Acreditação" icon="fas fa-clipboard-list">
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $laboratorio->escopo }}</p>
        </x-card>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status Card -->
        <x-card title="Status" icon="fas fa-info-circle">
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center gap-3">
                        @if($laboratorio->acreditado)
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                <i class="fas fa-certificate text-green-600 dark:text-green-400"></i>
                            </div>
                        @else
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-900/30">
                                <i class="fas fa-flask text-gray-600 dark:text-gray-400"></i>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $laboratorio->acreditado ? 'Acreditado' : 'Não Acreditado' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $laboratorio->acreditado ? 'RBC/ISO 17025' : 'Sem acreditação' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Timestamps -->
        <x-card title="Informações do Sistema" icon="fas fa-clock">
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cadastrado em</p>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $laboratorio->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Última atualização</p>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $laboratorio->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </x-card>

        <!-- Ações Rápidas -->
        <x-card title="Ações" icon="fas fa-bolt">
            <div class="space-y-2">
                <x-button variant="primary" icon="fas fa-edit" :href="route('laboratorios.edit', $laboratorio->id)" class="w-full justify-center">
                    Editar Laboratório
                </x-button>

                <form action="{{ route('laboratorios.destroy', $laboratorio->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir este laboratório?')">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" icon="fas fa-trash" type="submit" class="w-full justify-center">
                        Excluir Laboratório
                    </x-button>
                </form>
            </div>
        </x-card>
    </div>
</div>

@endsection

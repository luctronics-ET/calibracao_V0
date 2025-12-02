@extends('layouts.app')

@section('title', 'Laboratórios - CalibSys')

@section('page-title', 'Laboratórios')

@section('breadcrumb')
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <i class="fas fa-home mr-2"></i>
                Dashboard
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Laboratórios</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-flask text-blue-600 mr-2"></i>
        Gestão de Laboratórios
    </h2>

    <div class="flex gap-2">
        <x-button variant="primary" icon="fas fa-plus" :href="route('laboratorios.create')">
            Novo Laboratório
        </x-button>

        <x-button variant="outline" icon="fas fa-sync-alt" onclick="window.location.reload()">
            Atualizar
        </x-button>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 mb-6">
    <!-- Total de Laboratórios -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Laboratórios</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $laboratorios->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-flask text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Acreditados -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Acreditados</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $laboratorios->where('acreditado', true)->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-certificate text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <!-- Não Acreditados -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Não Acreditados</p>
                <p class="text-3xl font-bold text-gray-600 dark:text-gray-400 mt-2">{{ $laboratorios->where('acreditado', false)->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-900/30">
                <i class="fas fa-flask text-2xl text-gray-600 dark:text-gray-400"></i>
            </div>
        </div>
    </div>
</div>

<x-datatable3
    id="laboratoriosTable"
    title=""
    :headers="['ID', 'Nome', 'CNPJ', 'Acreditado', 'Contato', 'Escopo', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#laboratoriosTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#laboratoriosTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
                @forelse($laboratorios as $laboratorio)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium">{{ $laboratorio->id }}</td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $laboratorio->nome }}</p>
                            @if($laboratorio->endereco)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ \Illuminate\Support\Str::limit($laboratorio->endereco, 40) }}
                                </p>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $laboratorio->cnpj ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($laboratorio->acreditado)
                            <x-badge variant="success">
                                <i class="fas fa-check-circle mr-1"></i>Acreditado
                            </x-badge>
                        @else
                            <x-badge variant="default">
                                <i class="fas fa-minus-circle mr-1"></i>Não Acreditado
                            </x-badge>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $laboratorio->contato ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($laboratorio->escopo)
                            <span class="text-xs" title="{{ $laboratorio->escopo }}">
                                {{ \Illuminate\Support\Str::limit($laboratorio->escopo, 30) }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('laboratorios.show', $laboratorio->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('laboratorios.edit', $laboratorio->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('laboratorios.destroy', $laboratorio->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este laboratório?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Nenhum laboratório cadastrado</p>
                    </td>
                </tr>
                @endforelse
    </x-slot>
</x-datatable3>
@endsection

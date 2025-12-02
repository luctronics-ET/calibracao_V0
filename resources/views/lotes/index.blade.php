@extends('layouts.app')

@section('title', 'Lotes de Envio - CalibSys')

@section('page-title', 'Lotes de Envio')

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
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Lotes</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-boxes text-blue-600 mr-2"></i>
        Gestão de Lotes de Envio
    </h2>

    <div class="flex gap-2">
        <x-button variant="primary" icon="fas fa-plus" :href="route('lotes.create')">
            Novo Lote
        </x-button>

        <x-button variant="outline" icon="fas fa-sync-alt" onclick="window.location.reload()">
            Atualizar
        </x-button>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5 mb-6">
    <!-- Total de Lotes -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Lotes</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $lotes->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-boxes text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Em Preparação -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Em Preparação</p>
                <p class="text-3xl font-bold text-gray-500 dark:text-gray-300 mt-2">{{ $lotes->where('status', 'preparacao')->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-900/30">
                <i class="fas fa-clock text-2xl text-gray-600 dark:text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Enviados -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Enviados</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">{{ $lotes->where('status', 'enviado')->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                <i class="fas fa-shipping-fast text-2xl text-yellow-600 dark:text-yellow-400"></i>
            </div>
        </div>
    </div>

    <!-- Em Calibração -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Em Calibração</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $lotes->where('status', 'em_calibracao')->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-cogs text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Retornados -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Retornados</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $lotes->where('status', 'retornado')->count() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>
</div>

<x-datatable3
    id="lotesTable"
    title=""
    :headers="['ID', 'Código Lote', 'Data Envio', 'Data Retorno', 'Responsável', 'Transportadora', 'Status', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#lotesTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#lotesTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
                @forelse($lotes as $lote)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium">{{ $lote->id }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $lote->codigo_lote ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($lote->data_envio)
                            {{ \Carbon\Carbon::parse($lote->data_envio)->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($lote->data_retorno)
                            {{ \Carbon\Carbon::parse($lote->data_retorno)->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $lote->responsavel_envio ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $lote->transportadora ?? '-' }}</td>
                    <td class="px-6 py-4">
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
                        <x-badge variant="{{ $color }}">{{ $label }}</x-badge>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('lotes.show', $lote->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('lotes.edit', $lote->id) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('lotes.destroy', $lote->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este lote?')">
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
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Nenhum lote cadastrado</p>
                    </td>
                </tr>
                @endforelse
    </x-slot>
</x-datatable3>
@endsection

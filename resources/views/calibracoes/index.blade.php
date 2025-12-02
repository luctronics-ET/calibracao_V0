@extends('layouts.app')

@section('title', 'Calibrações - CalibSys')

@section('page-title', 'Calibrações')

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
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Calibrações</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-clipboard-check text-blue-600 mr-2"></i>
        Gestão de Calibrações
    </h2>

    <div class="flex gap-2">
        <x-button variant="primary" icon="fas fa-plus" :href="route('calibracoes.create')">
            Nova Calibração
        </x-button>

        <x-button variant="outline" icon="fas fa-sync-alt" onclick="window.location.reload()">
            Atualizar
        </x-button>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Calibrações</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $calibracoes->count() }}</p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-clipboard-check text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Este Mês</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $calibracoes->filter(function($c) {
                        return $c->data_calibracao && \Carbon\Carbon::parse($c->data_calibracao)->isCurrentMonth();
                    })->count() }}
                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-calendar-check text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Aprovadas</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $calibracoes->where('resultado', 'aprovado')->count() }}
                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Reprovadas</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                    {{ $calibracoes->where('resultado', 'reprovado')->count() }}
                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <i class="fas fa-times-circle text-2xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
    </div>
</div>

<x-datatable3
    id="calibracoesTable"
    title=""
    :headers="['ID', 'Equipamento', 'Laboratório', 'Data Calibração', 'Certificado', 'Resultado', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#calibracoesTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#calibracoesTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
                @forelse($calibracoes as $calibracao)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            #{{ $calibracao->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            {{ $calibracao->equipamento->equipamento_tipo ?? 'N/A' }}
                            <br>
                            <span class="text-xs text-gray-500">{{ $calibracao->equipamento->equipamento_codigo_interno ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            {{ $calibracao->laboratorio->nome ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            {{ $calibracao->data_calibracao ? \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                            {{ $calibracao->certificado_num ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($calibracao->resultado === 'aprovado')
                                <x-badge variant="success">
                                    <i class="fas fa-check-circle"></i> Aprovado
                                </x-badge>
                            @elseif($calibracao->resultado === 'reprovado')
                                <x-badge variant="danger">
                                    <i class="fas fa-times-circle"></i> Reprovado
                                </x-badge>
                            @elseif($calibracao->resultado === 'condicional')
                                <x-badge variant="warning">
                                    <i class="fas fa-exclamation-triangle"></i> Condicional
                                </x-badge>
                            @else
                                <x-badge variant="default">
                                    <i class="fas fa-clock"></i> Pendente
                                </x-badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('calibracoes.show', $calibracao->id) }}"
                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                   title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('calibracoes.edit', $calibracao->id) }}"
                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('calibracoes.destroy', $calibracao->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta calibração?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <i class="fas fa-inbox text-4xl text-gray-400 mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400">Nenhuma calibração cadastrada.</p>
                        </td>
                    </tr>
                @endforelse
    </x-slot>
</x-datatable3>
@endsection

@extends('layouts.app')

@section('title', 'Equipamentos - Sistema de Calibração')

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
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Equipamentos</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-cube text-blue-600 mr-2"></i>
        Gestão de Equipamentos
    </h2>

    <div class="flex gap-2">
        <a href="{{ route('equipamentos.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-plus"></i>
            Novo Equipamento
        </a>

        <button type="button" onclick="window.location.reload()" class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
            <i class="fas fa-sync-alt"></i>
            Atualizar
        </button>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
    <!-- Total de Equipamentos -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Equipamentos</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $equipamentos->count() }}</p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                <i class="fas fa-cube text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Equipamentos Ativos -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativos</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $equipamentos->where('equipamento_status', 'ativo')->count() }}
                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <!-- Calibrações Vencidas -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Calibrações Vencidas</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                    {{ $equipamentos->filter(function($e) {
                        return $e->equipamento_data_proxima_calibracao &&
                               \Carbon\Carbon::parse($e->equipamento_data_proxima_calibracao)->isPast();
                    })->count() }}
                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
                <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
    </div>

    <!-- A Vencer (30 dias) -->
    <div class="rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">A Vencer (30 dias)</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">
                    {{ $equipamentos->filter(function($e) {
                        return $e->equipamento_data_proxima_calibracao &&
                               \Carbon\Carbon::parse($e->equipamento_data_proxima_calibracao)->isBetween(now(), now()->addDays(30));
                    })->count() }}
                </p>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900">
                <i class="fas fa-clock text-2xl text-yellow-600 dark:text-yellow-400"></i>
            </div>
        </div>
    </div>
</div>

<x-datatable3
    id="equipamentosTable"
    title=""
    :headers="['ID', 'Código', 'Tipo', 'Fabricante', 'Modelo', 'Serial', 'Setor', 'Localização', 'Status Equipamento', 'Status Calibração', 'Última Calibração', 'Próx. Calibração', 'IGP', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#equipamentosTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#equipamentosTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
                    @forelse($equipamentos as $equipamento)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                #{{ $equipamento->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $equipamento->equipamento_codigo_interno ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $equipamento->equipamento_tipo ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $equipamento->equipamento_fabricante ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $equipamento->equipamento_modelo ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $equipamento->equipamento_serial ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $equipamento->equipamento_setor ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $equipamento->equipamento_localizacao ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($equipamento->equipamento_status === 'ativo')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                        <i class="fas fa-check-circle mr-1"></i> Ativo
                                    </span>
                                @elseif($equipamento->equipamento_status === 'inativo')
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        <i class="fas fa-pause-circle mr-1"></i> Inativo
                                    </span>
                                @elseif($equipamento->equipamento_status === 'manutencao')
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                        <i class="fas fa-tools mr-1"></i> Manutenção
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                        <i class="fas fa-ban mr-1"></i> Descartado
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($equipamento->equipamento_certificado_status === 'CALIBRADO')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                        <i class="fas fa-check-circle mr-1"></i> Calibrado
                                    </span>
                                @elseif($equipamento->equipamento_certificado_status === 'DESCALIBRADO')
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                        <i class="fas fa-times-circle mr-1"></i> Descalibrado
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                @if($equipamento->equipamento_data_ultima_calibracao)
                                    {{ \Carbon\Carbon::parse($equipamento->equipamento_data_ultima_calibracao)->format('d/m/Y') }}
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($equipamento->proxima_calibracao_prevista)
                                    @php
                                        $proximaData = \Carbon\Carbon::parse($equipamento->proxima_calibracao_prevista);
                                        $hoje = now();
                                        $vencida = $proximaData->isPast();
                                        $aVencer = $proximaData->isBetween($hoje, $hoje->copy()->addDays(30));
                                    @endphp

                                    @if($vencida)
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $proximaData->format('d/m/Y') }}
                                        </span>
                                    @elseif($aVencer)
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $proximaData->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-700 dark:text-gray-300">
                                            {{ $proximaData->format('d/m/Y') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($equipamento->equipamento_igp)
                                    @php
                                        $igp = $equipamento->equipamento_igp;
                                        if($igp >= 12) {
                                            $color = 'red';
                                        } elseif($igp >= 7) {
                                            $color = 'yellow';
                                        } else {
                                            $color = 'green';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center rounded-full bg-{{ $color }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300">
                                        {{ $igp }} - {{ ucfirst($equipamento->equipamento_classificacao ?? 'N/A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('equipamentos.show', $equipamento->id) }}"
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                       title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('equipamentos.edit', $equipamento->id) }}"
                                       class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('equipamentos.destroy', $equipamento->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este equipamento?');">
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
                            <td colspan="11" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-2 text-gray-400"></i>
                                <p>Nenhum equipamento cadastrado.</p>
                            </td>
                        </tr>
                    @endforelse
    </x-slot>
</x-datatable3>
@endsection

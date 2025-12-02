@extends('layouts.app')

@section('title', 'Contratos - CalibSys')

@section('page-title', 'Contratos de Serviço')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-file-contract text-blue-600 mr-2"></i>
        Gestão de Contratos
    </h2>

    <div class="flex gap-2">
        <x-button variant="primary" icon="fas fa-plus" :href="route('contratos.create')">
            Novo Contrato
        </x-button>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-3 mb-6">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Contratos</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $contratos->total() }}</p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-file-contract text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ativos</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $contratos->filter(fn($c) => $c->data_fim && $c->data_fim >= now())->count() }}
                </p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Vencidos</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                    {{ $contratos->filter(fn($c) => $c->data_fim && $c->data_fim < now())->count() }}
                </p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tabela -->
<x-datatable3
    id="contratosTable"
    title="Lista de Contratos"
    subtitle="Gerencie todos os contratos de serviço"
    :headers="['Número', 'Laboratório', 'Início', 'Fim', 'Valor', 'Status', 'Ações']"
    :exportable="true"
>
    <x-slot name="actions">
        <x-button variant="outline" icon="fas fa-file-excel" onclick="$('#contratosTable').DataTable().button('.buttons-excel').trigger();">
            Excel
        </x-button>
        <x-button variant="outline" icon="fas fa-file-pdf" onclick="$('#contratosTable').DataTable().button('.buttons-pdf').trigger();">
            PDF
        </x-button>
    </x-slot>

    <x-slot name="body">
        @forelse($contratos as $contrato)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
            <td class="px-4 py-3">
                <span class="font-semibold text-gray-900 dark:text-white">{{ $contrato->numero_contrato }}</span>
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                {{ $contrato->laboratorio->nome ?? '-' }}
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                {{ $contrato->data_inicio ? $contrato->data_inicio->format('d/m/Y') : '-' }}
            </td>
            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                {{ $contrato->data_fim ? $contrato->data_fim->format('d/m/Y') : '-' }}
            </td>
            <td class="px-4 py-3">
                @if($contrato->valor_contrato)
                    <span class="font-medium text-gray-900 dark:text-white">
                        R$ {{ number_format($contrato->valor_contrato, 2, ',', '.') }}
                    </span>
                @else
                    <span class="text-gray-400">-</span>
                @endif
            </td>
            <td class="px-4 py-3">
                @if($contrato->data_fim && $contrato->data_fim >= now())
                    <span class="inline-flex items-center rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                        Ativo
                    </span>
                @elseif($contrato->data_fim)
                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-500/15 dark:text-red-500">
                        Vencido
                    </span>
                @else
                    <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-500/15 dark:text-gray-400">
                        Indefinido
                    </span>
                @endif
            </td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                    <a href="{{ route('contratos.show', $contrato) }}"
                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10"
                       title="Visualizar">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('contratos.edit', $contrato) }}"
                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-500/10"
                       title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('contratos.destroy', $contrato) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10"
                                onclick="return confirm('Tem certeza que deseja excluir este contrato?')"
                                title="Excluir">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-inbox text-4xl mb-2 text-gray-300 dark:text-gray-600"></i>
                <p>Nenhum contrato cadastrado</p>
            </td>
        </tr>
        @endforelse
    </x-slot>
</x-datatable3>
@endsection

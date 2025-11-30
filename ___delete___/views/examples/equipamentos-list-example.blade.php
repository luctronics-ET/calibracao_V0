@extends('layouts.tailadmin')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Equipamentos', 'url' => '']
        ];
    @endphp

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Equipamentos</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerencie todos os equipamentos cadastrados</p>
        </div>
        <div class="flex gap-2">
            <x-button variant="outline" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exportar
            </x-button>
            <x-button variant="primary" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Novo Equipamento
            </x-button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card title="Total de Equipamentos" value="1.234" trend="up" trendValue="+5.2%" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z\'/></svg>'" iconBg="bg-indigo-100"
            iconColor="text-indigo-600" />

        <x-stat-card title="Em Calibração" value="45" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>'" iconBg="bg-blue-100" iconColor="text-blue-600" />

        <x-stat-card title="Vencendo em 30 dias" value="23" trend="down" trendValue="-2.1%" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\'/></svg>'"
            iconBg="bg-yellow-100" iconColor="text-yellow-600" />

        <x-stat-card title="Calibrados este Mês" value="89" trend="up" trendValue="+8.4%" :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg>'"
            iconBg="bg-green-100" iconColor="text-green-600" />
    </div>

    {{-- Filters & Search --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('equipamentos.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-input name="search" type="text" placeholder="Buscar por código ou tipo..."
                    value="{{ request('search') }}" />

                <x-select name="criticidade" :options="[
            '' => 'Todas Criticidades',
            'baixa' => 'Baixa',
            'media' => 'Média',
            'alta' => 'Alta',
            'critica' => 'Crítica'
        ]" :selected="request('criticidade')" />

                <x-select name="status" :options="[
            '' => 'Todos Status',
            'ativo' => 'Ativo',
            'calibracao' => 'Em Calibração',
            'vencido' => 'Vencido'
        ]" :selected="request('status')" />

                <div class="flex gap-2">
                    <x-button variant="primary" type="submit" size="md" class="flex-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Buscar
                    </x-button>
                    <x-button variant="outline" type="button" size="md">
                        Limpar
                    </x-button>
                </div>
            </div>
        </form>
    </x-card>

    {{-- Main Table --}}
    <x-card title="Lista de Equipamentos">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Código</th>
                        <th scope="col" class="px-6 py-3">Tipo</th>
                        <th scope="col" class="px-6 py-3">Criticidade</th>
                        <th scope="col" class="px-6 py-3">Última Calibração</th>
                        <th scope="col" class="px-6 py-3">Próxima Calibração</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipamentos ?? [] as $equipamento)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $equipamento->codigo_interno }}
                            </td>
                            <td class="px-6 py-4">{{ $equipamento->tipo }}</td>
                            <td class="px-6 py-4">
                                @if($equipamento->criticidade === 'critica')
                                    <x-badge variant="danger">Crítica</x-badge>
                                @elseif($equipamento->criticidade === 'alta')
                                    <x-badge variant="warning">Alta</x-badge>
                                @elseif($equipamento->criticidade === 'media')
                                    <x-badge variant="info">Média</x-badge>
                                @else
                                    <x-badge variant="success">Baixa</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $equipamento->ultima_calibracao ? $equipamento->ultima_calibracao->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $equipamento->proxima_calibracao ? $equipamento->proxima_calibracao->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <x-badge variant="success">Ativo</x-badge>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('equipamentos.show', $equipamento) }}"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('equipamentos.edit', $equipamento) }}"
                                        class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button class="text-red-600 hover:text-red-900 dark:text-red-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm">Nenhum equipamento encontrado</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($equipamentos) && $equipamentos->hasPages())
            <div class="mt-4">
                {{ $equipamentos->links() }}
            </div>
        @endif
    </x-card>

@endsection
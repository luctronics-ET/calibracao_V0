@extends('layouts.app')

@section('title', 'Dashboard - CalibSys')

@section('page-title', 'Dashboard')

@section('content')

<!-- KPI Cards -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 mb-6">

    <!-- Total de Equipamentos -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Equipamentos</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                    {{ $totalEquipamentos }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $equipamentosAtivos }} ativos
                </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-cube text-3xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Calibrações Vencidas -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Calibrações Vencidas</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                    {{ $calibracoesVencidas }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Ação imediata necessária
                </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600 dark:text-red-400"></i>
            </div>
        </div>
    </div>

    <!-- A Vencer (30 dias) -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">A Vencer (30 dias)</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">
                    {{ $calibracoesAVencer }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Planeje agora
                </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                <i class="fas fa-clock text-3xl text-yellow-600 dark:text-yellow-400"></i>
            </div>
        </div>
    </div>

    <!-- Lotes Ativos -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lotes Ativos</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                    {{ $lotesAtivos }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Em processamento
                </p>
            </div>
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-boxes text-3xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    <!-- Gráfico de Calibrações por Mês -->
    <x-card title="Calibrações nos Últimos 12 Meses" icon="fas fa-chart-line" :padding="false">
        <div class="p-6">
            <canvas id="calibracoesChart" height="300"></canvas>
        </div>
    </x-card>

    <!-- Gráfico de Equipamentos por Status -->
    <x-card title="Equipamentos por Status" icon="fas fa-chart-pie" :padding="false">
        <div class="p-6">
            <canvas id="statusChart" height="300"></canvas>
        </div>
    </x-card>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    <!-- Equipamentos com Calibração Vencida -->
    <x-card title="Equipamentos com Calibração Vencida" icon="fas fa-exclamation-triangle">
        @if($equipamentosVencidosLista->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Equipamento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Vencimento</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($equipamentosVencidosLista->take(5) as $equipamento)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $equipamento->equipamento_tipo ?? 'N/A' }}
                                    <br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $equipamento->equipamento_codigo_interno ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <x-badge variant="danger">
                                        {{ \Carbon\Carbon::parse($equipamento->equipamento_data_proxima_calibracao)->format('d/m/Y') }}
                                    </x-badge>
                                </td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <a href="{{ route('equipamentos.show', $equipamento->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        Ver <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($equipamentosVencidosLista->count() > 5)
                <div class="mt-4 text-center">
                    <a href="{{ route('equipamentos.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Ver todos ({{ $equipamentosVencidosLista->count() }})
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <i class="fas fa-check-circle text-5xl text-green-500 dark:text-green-400 mb-3"></i>
                <p class="text-gray-600 dark:text-gray-400">Nenhum equipamento com calibração vencida!</p>
            </div>
        @endif
    </x-card>

    <!-- Equipamentos A Vencer -->
    <x-card title="Próximas Calibrações (30 dias)" icon="fas fa-clock">
        @if($equipamentosAVencerLista->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Equipamento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Vencimento</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($equipamentosAVencerLista->take(5) as $equipamento)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $equipamento->equipamento_tipo ?? 'N/A' }}
                                    <br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $equipamento->equipamento_codigo_interno ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <x-badge variant="warning">
                                        {{ \Carbon\Carbon::parse($equipamento->equipamento_data_proxima_calibracao)->format('d/m/Y') }}
                                    </x-badge>
                                </td>
                                <td class="px-4 py-3 text-sm text-right">
                                    <a href="{{ route('equipamentos.show', $equipamento->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        Ver <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($equipamentosAVencerLista->count() > 5)
                <div class="mt-4 text-center">
                    <a href="{{ route('equipamentos.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Ver todos ({{ $equipamentosAVencerLista->count() }})
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-check text-5xl text-gray-400 mb-3"></i>
                <p class="text-gray-600 dark:text-gray-400">Nenhuma calibração prevista para os próximos 30 dias</p>
            </div>
        @endif
    </x-card>

</div>

<!-- Ações Rápidas -->
<x-card title="Ações Rápidas" icon="fas fa-bolt">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-button variant="primary" icon="fas fa-plus" :href="route('equipamentos.create')" class="w-full justify-center">
            Novo Equipamento
        </x-button>

        <x-button variant="success" icon="fas fa-clipboard-check" :href="route('calibracoes.create')" class="w-full justify-center">
            Nova Calibração
        </x-button>

        <x-button variant="info" icon="fas fa-boxes" :href="route('lotes.create')" class="w-full justify-center">
            Novo Lote
        </x-button>

        <x-button variant="secondary" icon="fas fa-chart-bar" href="#" class="w-full justify-center">
            Gerar Relatório
        </x-button>
    </div>
</x-card>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Gráfico de Calibrações por Mês
    const calibracoesCtx = document.getElementById('calibracoesChart').getContext('2d');
    new Chart(calibracoesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($calibracoesMeses['labels']) !!},
            datasets: [{
                label: 'Calibrações Realizadas',
                data: {!! json_encode($calibracoesMeses['data']) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico de Status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusData['labels']) !!},
            datasets: [{
                data: {!! json_encode($statusData['data']) !!},
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(156, 163, 175)',
                    'rgb(234, 179, 8)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush

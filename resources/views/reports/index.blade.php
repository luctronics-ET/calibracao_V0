@extends('layouts.app')
@section('title', 'Relatórios - CalibSys')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
        Relatórios Gerais
    </h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <x-card title="Vencimentos" icon="fas fa-exclamation-triangle">
        <p class="text-gray-600 dark:text-gray-400 mb-4">Equipamentos com calibrações vencidas ou próximas do vencimento</p>
        <x-button variant="primary" :href="route('reports.vencimentos')" class="w-full">Visualizar Relatório</x-button>
    </x-card>

    <x-card title="Histórico" icon="fas fa-history">
        <p class="text-gray-600 dark:text-gray-400 mb-4">Histórico completo de calibrações realizadas</p>
        <x-button variant="primary" :href="route('reports.historico')" class="w-full">Visualizar Relatório</x-button>
    </x-card>

    <x-card title="Custos" icon="fas fa-dollar-sign">
        <p class="text-gray-600 dark:text-gray-400 mb-4">Análise de custos de calibrações por período</p>
        <x-button variant="primary" :href="route('reports.custos')" class="w-full">Visualizar Relatório</x-button>
    </x-card>

    <x-card title="IGP" icon="fas fa-chart-line">
        <p class="text-gray-600 dark:text-gray-400 mb-4">Índice de Gestão de Padrões por equipamento</p>
        <x-button variant="primary" :href="route('reports.igp')" class="w-full">Visualizar Relatório</x-button>
    </x-card>

    <x-card title="Certificados" icon="fas fa-certificate">
        <p class="text-gray-600 dark:text-gray-400 mb-4">Gestão de certificados de calibração</p>
        <x-button variant="primary" :href="route('reports.certificados')" class="w-full">Visualizar Relatório</x-button>
    </x-card>

    <x-card title="Laboratórios" icon="fas fa-flask">
        <p class="text-gray-600 dark:text-gray-400 mb-4">Performance e análise de laboratórios</p>
        <x-button variant="primary" :href="route('laboratorios.index')" class="w-full">Visualizar</x-button>
    </x-card>
</div>
@endsection

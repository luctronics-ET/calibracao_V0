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

@php
    // Preparar dados para filtros
    $tiposEquipamento = $equipamentos->pluck('equipamento_tipo')->filter()->unique()->sort()->values();
    $fabricantes = $equipamentos->pluck('equipamento_fabricante')->filter()->unique()->sort()->values();
    $modelos = $equipamentos->pluck('equipamento_modelo')->filter()->unique()->sort()->values();
    $setores = $equipamentos->pluck('equipamento_setor')->filter()->unique()->sort()->values();
    $statusCalibracao = $equipamentos->pluck('equipamento_certificado_status')->filter()->unique()->sort()->values();

    // Ordenar tipos: Elétricos primeiro, depois Mecânicos, depois Dimensionais
    $tiposOrdenados = $tiposEquipamento->sortBy(function($tipo) {
        $tipoLower = strtolower($tipo);
        if (str_contains($tipoLower, 'elét') || str_contains($tipoLower, 'elet')) return 1;
        if (str_contains($tipoLower, 'mecân') || str_contains($tipoLower, 'mecan')) return 2;
        if (str_contains($tipoLower, 'dimen') || str_contains($tipoLower, 'dim')) return 3;
        return 4;
    })->values();
@endphp

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

<!-- Filtros Avançados - Multiple Select com TailAdmin Style -->
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
    <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                <i class="fas fa-filter text-blue-600 mr-2"></i>
                Filtros Avançados
            </h3>
            <button type="button" onclick="limparFiltros()" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                <i class="fas fa-times"></i>
                Limpar Filtros
            </button>
        </div>
    </div>

    <div class="p-5 sm:p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Busca Geral -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Buscar
                </label>
                <div class="relative">
                    <input type="text" id="searchGeral" placeholder="Código, descrição..."
                        class="dark:bg-gray-900 shadow-theme-xs focus:border-blue-300 focus:ring-blue-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>

            <!-- Setor - Multiple Select -->
            <div x-data="multiSelect('setor', {{ json_encode($setores) }})" class="relative">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Setor
                </label>
                <div class="relative">
                    <div @click="open = !open"
                         class="cursor-pointer dark:bg-gray-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90 flex items-center overflow-hidden"
                         :class="selected.length > 0 ? 'border-blue-500' : ''">
                        <span x-show="selected.length === 0" class="text-gray-400">Selecionar...</span>
                        <div x-show="selected.length > 0" class="flex flex-wrap gap-1 overflow-hidden">
                            <template x-for="(item, idx) in selected.slice(0, 2)" :key="idx">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800" x-text="item.length > 15 ? item.substring(0, 15) + '...' : item"></span>
                            </template>
                            <span x-show="selected.length > 2" class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800" x-text="'+' + (selected.length - 2)"></span>
                        </div>
                    </div>
                    <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500" :class="open ? 'rotate-180' : ''">
                        <i class="fas fa-chevron-down transition-transform"></i>
                    </span>

                    <!-- Dropdown -->
                    <div x-show="open" x-cloak @click.outside="open = false"
                         class="absolute z-50 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900 max-h-60 overflow-y-auto">
                        <template x-for="(option, index) in options" :key="index">
                            <div @click="toggleOption(option)"
                                 class="flex items-center px-4 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-800"
                                 :class="selected.includes(option) ? 'bg-blue-50 dark:bg-gray-800' : ''">
                                <input type="checkbox" :checked="selected.includes(option)" class="mr-2 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-800 dark:text-gray-200" x-text="option"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Tipo Equipamento - Multiple Select -->
            <div x-data="multiSelect('tipo', {{ json_encode($tiposOrdenados) }})" class="relative">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Tipo Equipamento
                </label>
                <div class="relative">
                    <div @click="open = !open"
                         class="cursor-pointer dark:bg-gray-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90 flex items-center overflow-hidden"
                         :class="selected.length > 0 ? 'border-blue-500' : ''">
                        <span x-show="selected.length === 0" class="text-gray-400">Selecionar...</span>
                        <div x-show="selected.length > 0" class="flex flex-wrap gap-1 overflow-hidden">
                            <template x-for="(item, idx) in selected.slice(0, 2)" :key="idx">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800" x-text="item.length > 15 ? item.substring(0, 15) + '...' : item"></span>
                            </template>
                            <span x-show="selected.length > 2" class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800" x-text="'+' + (selected.length - 2)"></span>
                        </div>
                    </div>
                    <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500" :class="open ? 'rotate-180' : ''">
                        <i class="fas fa-chevron-down transition-transform"></i>
                    </span>

                    <!-- Dropdown -->
                    <div x-show="open" x-cloak @click.outside="open = false"
                         class="absolute z-50 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900 max-h-60 overflow-y-auto">
                        <template x-for="(option, index) in options" :key="index">
                            <div @click="toggleOption(option)"
                                 class="flex items-center px-4 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-800"
                                 :class="selected.includes(option) ? 'bg-blue-50 dark:bg-gray-800' : ''">
                                <input type="checkbox" :checked="selected.includes(option)" class="mr-2 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-800 dark:text-gray-200" x-text="option"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Status Calibração - Multiple Select -->
            <div x-data="multiSelect('status', {{ json_encode($statusCalibracao) }})" class="relative">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Status Calibração
                </label>
                <div class="relative">
                    <div @click="open = !open"
                         class="cursor-pointer dark:bg-gray-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 dark:border-gray-700 dark:text-white/90 flex items-center overflow-hidden"
                         :class="selected.length > 0 ? 'border-blue-500' : ''">
                        <span x-show="selected.length === 0" class="text-gray-400">Selecionar...</span>
                        <div x-show="selected.length > 0" class="flex flex-wrap gap-1 overflow-hidden">
                            <template x-for="(item, idx) in selected.slice(0, 2)" :key="idx">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800" x-text="item"></span>
                            </template>
                            <span x-show="selected.length > 2" class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800" x-text="'+' + (selected.length - 2)"></span>
                        </div>
                    </div>
                    <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500" :class="open ? 'rotate-180' : ''">
                        <i class="fas fa-chevron-down transition-transform"></i>
                    </span>

                    <!-- Dropdown -->
                    <div x-show="open" x-cloak @click.outside="open = false"
                         class="absolute z-50 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900 max-h-60 overflow-y-auto">
                        <template x-for="(option, index) in options" :key="index">
                            <div @click="toggleOption(option)"
                                 class="flex items-center px-4 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-800"
                                 :class="selected.includes(option) ? 'bg-blue-50 dark:bg-gray-800' : ''">
                                <input type="checkbox" :checked="selected.includes(option)" class="mr-2 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-800 dark:text-gray-200" x-text="option"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Próxima Calibração (Meses) -->
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Próx. Calibração
                </label>
                <select id="filterProxCalib"
                    class="dark:bg-gray-900 shadow-theme-xs h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-10 text-sm text-gray-800 focus:border-blue-300 focus:ring-blue-500/10 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90">
                    <option value="">Todos</option>
                    <option value="vencido">Vencidas</option>
                    <option value="30">Próximos 30 dias</option>
                    <option value="60">Próximos 60 dias</option>
                    <option value="90">Próximos 90 dias</option>
                    <option value="180">Próximos 6 meses</option>
                    <option value="365">Próximo ano</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Tabela de Equipamentos -->
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Lista de Equipamentos</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    <span id="filteredCount">{{ $equipamentos->count() }}</span> equipamentos encontrados
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="$('#equipamentosTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                    <i class="fas fa-file-excel"></i>
                    Excel
                </button>
                <button onclick="$('#equipamentosTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                    <i class="fas fa-file-pdf"></i>
                    PDF
                </button>
            </div>
        </div>
    </div>

    <div class="p-5 sm:p-6">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto" id="equipamentosTable">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 text-left">
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700" onclick="sortTable(0)">
                            <div class="flex items-center gap-2">
                                Setor
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700" onclick="sortTable(1)">
                            <div class="flex items-center gap-2">
                                Equipamento/Código
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700" onclick="sortTable(2)">
                            <div class="flex items-center gap-2">
                                Fabricante/Modelo
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700" onclick="sortTable(3)">
                            <div class="flex items-center gap-2">
                                Status Calibração
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700" onclick="sortTable(4)">
                            <div class="flex items-center gap-2">
                                Próx. Calibração
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700" onclick="sortTable(5)">
                            <div class="flex items-center gap-2">
                                Última Calibração
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-4 py-3 font-medium text-gray-900 dark:text-white text-sm">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($equipamentos as $equipamento)
                        @php
                            $proximaData = $equipamento->proxima_calibracao_prevista ? \Carbon\Carbon::parse($equipamento->proxima_calibracao_prevista) : null;
                            $vencida = $proximaData && $proximaData->isPast();
                            $aVencer30 = $proximaData && $proximaData->isBetween(now(), now()->addDays(30));
                            $aVencer60 = $proximaData && $proximaData->isBetween(now(), now()->addDays(60));
                            $aVencer90 = $proximaData && $proximaData->isBetween(now(), now()->addDays(90));
                            $diasParaVencer = $proximaData ? now()->diffInDays($proximaData, false) : null;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                            data-setor="{{ $equipamento->equipamento_setor ?? '' }}"
                            data-tipo="{{ $equipamento->equipamento_tipo ?? '' }}"
                            data-status="{{ $equipamento->equipamento_certificado_status ?? '' }}"
                            data-dias="{{ $diasParaVencer }}">
                            <!-- Setor -->
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    {{ $equipamento->equipamento_setor ?? '-' }}
                                </span>
                            </td>

                            <!-- Equipamento/Código -->
                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ \Illuminate\Support\Str::limit($equipamento->equipamento_tipo ?? '-', 40) }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-barcode mr-1"></i>{{ $equipamento->equipamento_codigo_interno ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Fabricante/Modelo -->
                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $equipamento->equipamento_fabricante ?? '-' }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($equipamento->equipamento_modelo ?? '-', 30) }}
                                    </span>
                                </div>
                            </td>

                            <!-- Status Calibração -->
                            <td class="px-4 py-3">
                                @if($equipamento->equipamento_certificado_status === 'CALIBRADO')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                        <i class="fas fa-check-circle mr-1"></i>Calibrado
                                    </span>
                                @elseif($equipamento->equipamento_certificado_status === 'DESCALIBRADO')
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                        <i class="fas fa-times-circle mr-1"></i>Descalibrado
                                    </span>
                                @elseif($equipamento->equipamento_certificado_status === 'EM CALIBRAÇÃO')
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400">
                                        <i class="fas fa-clock mr-1"></i>Em Calibração
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-gray-400 text-xs">
                                        <i class="fas fa-minus-circle mr-1"></i>{{ $equipamento->equipamento_certificado_status ?? '-' }}
                                    </span>
                                @endif
                            </td>

                            <!-- Próxima Calibração -->
                            <td class="px-4 py-3 text-sm" data-order="{{ $proximaData ? $proximaData->format('Y-m-d') : '9999-12-31' }}">
                                @if($proximaData)
                                    @if($vencida)
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>{{ $proximaData->format('d/m/Y') }}
                                        </span>
                                    @elseif($aVencer30)
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400">
                                            <i class="fas fa-clock mr-1"></i>{{ $proximaData->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-700 dark:text-gray-300">{{ $proximaData->format('d/m/Y') }}</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Última Calibração -->
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                @if($equipamento->equipamento_data_ultima_calibracao)
                                    {{ \Carbon\Carbon::parse($equipamento->equipamento_data_ultima_calibracao)->format('d/m/Y') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Ações -->
                            <td class="px-4 py-3 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('equipamentos.show', $equipamento->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 dark:bg-blue-900/50 dark:text-blue-400 dark:hover:bg-blue-900 transition-colors"
                                       title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('equipamentos.edit', $equipamento->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 dark:bg-yellow-900/50 dark:text-yellow-400 dark:hover:bg-yellow-900 transition-colors"
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
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/50 dark:text-red-400 dark:hover:bg-red-900 transition-colors"
                                                title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-400"></i>
                                    <p>Nenhum equipamento cadastrado.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Componente Alpine.js para Multiple Select
function multiSelect(name, options) {
    return {
        name: name,
        options: options,
        selected: [],
        open: false,
        toggleOption(option) {
            const idx = this.selected.indexOf(option);
            if (idx > -1) {
                this.selected.splice(idx, 1);
            } else {
                this.selected.push(option);
            }
            this.applyFilters();
        },
        clearSelection() {
            this.selected = [];
            this.applyFilters();
        },
        applyFilters() {
            window.applyAllFilters();
        }
    }
}

// Variáveis globais para filtros
let dataTable = null;

$(document).ready(function() {
    // Inicializar DataTable
    dataTable = $('#equipamentosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
        },
        responsive: true,
        pageLength: 20,
        lengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Todos"]],
        order: [[0, 'asc'], [1, 'asc']], // Ordenar por Setor, depois por Equipamento
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'hidden',
                text: 'Excel',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'pdf',
                className: 'hidden',
                text: 'PDF',
                exportOptions: { columns: ':not(:last-child)' }
            }
        ],
        drawCallback: function() {
            // Atualizar contador
            var info = this.api().page.info();
            $('#filteredCount').text(info.recordsDisplay);
        }
    });

    // Busca geral
    $('#searchGeral').on('keyup', function() {
        dataTable.search(this.value).draw();
    });

    // Filtro por próxima calibração
    $('#filterProxCalib').on('change', function() {
        window.applyAllFilters();
    });
});

// Função para aplicar todos os filtros
window.applyAllFilters = function() {
    const setorFilter = Alpine.$data(document.querySelector('[x-data*="setor"]'))?.selected || [];
    const tipoFilter = Alpine.$data(document.querySelector('[x-data*="tipo"]'))?.selected || [];
    const statusFilter = Alpine.$data(document.querySelector('[x-data*="status"]'))?.selected || [];
    const proxCalibFilter = document.getElementById('filterProxCalib').value;

    $.fn.dataTable.ext.search.pop(); // Remove filtro anterior

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        const row = dataTable.row(dataIndex).node();
        const setor = $(row).data('setor') || '';
        const tipo = $(row).data('tipo') || '';
        const status = $(row).data('status') || '';
        const dias = parseInt($(row).data('dias')) || 9999;

        // Filtro de Setor
        if (setorFilter.length > 0 && !setorFilter.includes(setor)) {
            return false;
        }

        // Filtro de Tipo
        if (tipoFilter.length > 0 && !tipoFilter.includes(tipo)) {
            return false;
        }

        // Filtro de Status
        if (statusFilter.length > 0 && !statusFilter.includes(status)) {
            return false;
        }

        // Filtro de Próxima Calibração
        if (proxCalibFilter) {
            if (proxCalibFilter === 'vencido' && dias >= 0) return false;
            if (proxCalibFilter === '30' && (dias < 0 || dias > 30)) return false;
            if (proxCalibFilter === '60' && (dias < 0 || dias > 60)) return false;
            if (proxCalibFilter === '90' && (dias < 0 || dias > 90)) return false;
            if (proxCalibFilter === '180' && (dias < 0 || dias > 180)) return false;
            if (proxCalibFilter === '365' && (dias < 0 || dias > 365)) return false;
        }

        return true;
    });

    dataTable.draw();
}

// Função para limpar filtros
function limparFiltros() {
    // Limpar busca
    $('#searchGeral').val('');
    dataTable.search('').draw();

    // Limpar próxima calibração
    $('#filterProxCalib').val('');

    // Limpar multiple selects (Alpine.js)
    document.querySelectorAll('[x-data]').forEach(el => {
        const data = Alpine.$data(el);
        if (data && data.selected) {
            data.selected = [];
        }
    });

    // Remover filtros customizados
    $.fn.dataTable.ext.search = [];
    dataTable.draw();
}

// Função para ordenar tabela (chamada pelos headers)
function sortTable(colIndex) {
    if (dataTable) {
        const currentOrder = dataTable.order()[0];
        const newDir = (currentOrder && currentOrder[0] === colIndex && currentOrder[1] === 'asc') ? 'desc' : 'asc';
        dataTable.order([colIndex, newDir]).draw();
    }
}
</script>
@endpush

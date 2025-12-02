@extends('layouts.app')

@section('title', 'Visualizar Equipamento - Sistema de Calibração')

@section('page-title', 'Equipamento #' . $equipamento->id)

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
                <a href="{{ route('equipamentos.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">Equipamentos</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">#{{ $equipamento->id }}</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
        <i class="fas fa-cube text-blue-600"></i>
        <span>{{ $equipamento->equipamento_tipo ?? 'Equipamento' }} #{{ $equipamento->id }}</span>

        @if($equipamento->equipamento_status === 'ativo')
            <x-badge variant="success">Ativo</x-badge>
        @elseif($equipamento->equipamento_status === 'inativo')
            <x-badge variant="default">Inativo</x-badge>
        @elseif($equipamento->equipamento_status === 'manutencao')
            <x-badge variant="warning">Manutenção</x-badge>
        @else
            <x-badge variant="danger">Descartado</x-badge>
        @endif
    </h2>

    <div class="flex gap-2">
        <x-button variant="secondary" icon="fas fa-edit" :href="route('equipamentos.edit', $equipamento->id)">
            Editar
        </x-button>

        <x-button variant="outline" icon="fas fa-arrow-left" :href="route('equipamentos.index')">
            Voltar
        </x-button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Coluna Principal -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Informações Básicas -->
        <x-card title="Informações Básicas" icon="fas fa-info-circle">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Classe</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_classe ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_tipo ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Código Interno</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $equipamento->equipamento_codigo_interno ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de Série</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $equipamento->equipamento_serial ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fabricante</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_fabricante ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Modelo</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_modelo ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <!-- Características Técnicas -->
        <x-card title="Características Técnicas" icon="fas fa-cogs">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Resolução</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_resolucao ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Faixa de Medição</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_faixa_medicao ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Incerteza Nominal</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_incerteza_nominal ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dimensões (A×L×C)</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        @if($equipamento->equipamento_altura_mm || $equipamento->equipamento_largura_mm || $equipamento->equipamento_comprimento_mm)
                            {{ $equipamento->equipamento_altura_mm ?? '?' }}×{{ $equipamento->equipamento_largura_mm ?? '?' }}×{{ $equipamento->equipamento_comprimento_mm ?? '?' }} mm
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tensão</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_tensao_v ? $equipamento->equipamento_tensao_v . ' V' : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Potência</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_potencia_w ? $equipamento->equipamento_potencia_w . ' W' : '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <!-- Calibração -->
        <x-card title="Dados de Calibração" icon="fas fa-calendar-check">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Calibração</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $equipamento->equipamento_data_ultima_calibracao ? \Carbon\Carbon::parse($equipamento->equipamento_data_ultima_calibracao)->format('d/m/Y') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Próxima Calibração</dt>
                    <dd class="mt-1 text-sm">
                        @if($equipamento->equipamento_data_proxima_calibracao)
                            @php
                                $proximaData = \Carbon\Carbon::parse($equipamento->equipamento_data_proxima_calibracao);
                                $vencida = $proximaData->isPast();
                                $aVencer = $proximaData->isBetween(now(), now()->addDays(30));
                            @endphp

                            @if($vencida)
                                <x-badge variant="danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ $proximaData->format('d/m/Y') }} (Vencida)
                                </x-badge>
                            @elseif($aVencer)
                                <x-badge variant="warning">
                                    <i class="fas fa-clock"></i>
                                    {{ $proximaData->format('d/m/Y') }} (A vencer)
                                </x-badge>
                            @else
                                <span class="text-gray-900 dark:text-white">{{ $proximaData->format('d/m/Y') }}</span>
                            @endif
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Periodicidade</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $equipamento->equipamento_periodicidade_meses ? $equipamento->equipamento_periodicidade_meses . ' meses' : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Local de Calibração</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_local_calibracao ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <!-- Documentação -->
        @if($equipamento->equipamento_instrucao_uso || $equipamento->equipamento_instrucao_operacao || $equipamento->equipamento_instrucao_seguranca || $equipamento->equipamento_comentarios)
        <x-card title="Documentação e Instruções" icon="fas fa-file-alt">
            @if($equipamento->equipamento_instrucao_uso)
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instruções de Uso</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $equipamento->equipamento_instrucao_uso }}</p>
                </div>
            @endif

            @if($equipamento->equipamento_instrucao_operacao)
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instruções de Operação</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $equipamento->equipamento_instrucao_operacao }}</p>
                </div>
            @endif

            @if($equipamento->equipamento_instrucao_seguranca)
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Instruções de Segurança</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $equipamento->equipamento_instrucao_seguranca }}</p>
                </div>
            @endif

            @if($equipamento->equipamento_comentarios)
                <div>
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comentários</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $equipamento->equipamento_comentarios }}</p>
                </div>
            @endif
        </x-card>
        @endif

    </div>

    <!-- Sidebar -->
    <div class="space-y-6">

        <!-- Foto -->
        @if($equipamento->equipamento_foto)
        <x-card title="Foto" icon="fas fa-camera">
            <img src="{{ asset('storage/' . $equipamento->equipamento_foto) }}" alt="Foto do equipamento" class="w-full rounded-lg">
        </x-card>
        @endif

        <!-- Status e Localização -->
        <x-card title="Status e Localização" icon="fas fa-map-marker-alt">
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-1">
                        @if($equipamento->equipamento_status === 'ativo')
                            <x-badge variant="success"><i class="fas fa-check-circle"></i> Ativo</x-badge>
                        @elseif($equipamento->equipamento_status === 'inativo')
                            <x-badge variant="default"><i class="fas fa-pause-circle"></i> Inativo</x-badge>
                        @elseif($equipamento->equipamento_status === 'manutencao')
                            <x-badge variant="warning"><i class="fas fa-tools"></i> Manutenção</x-badge>
                        @else
                            <x-badge variant="danger"><i class="fas fa-ban"></i> Descartado</x-badge>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Localização</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_localizacao ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Setor</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $equipamento->equipamento_setor ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <!-- IGP -->
        <x-card title="Índice IGP" icon="fas fa-chart-line">
            <div class="text-center">
                @if($equipamento->equipamento_igp)
                    @php
                        $igp = $equipamento->equipamento_igp;
                        if($igp >= 12) {
                            $color = 'red';
                            $label = 'Alta';
                        } elseif($igp >= 7) {
                            $color = 'yellow';
                            $label = 'Média';
                        } else {
                            $color = 'green';
                            $label = 'Baixa';
                        }
                    @endphp
                    <div class="text-4xl font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400 mb-2">
                        {{ $igp }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Classificação: <strong>{{ $label }}</strong>
                    </div>

                    <dl class="space-y-2 text-sm text-left">
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Frequência de Uso:</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $equipamento->equipamento_frequencia_uso ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Necessidade Crítica:</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $equipamento->equipamento_necessidade_critica ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Abundância:</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $equipamento->equipamento_abundancia ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Custo Indisponibilidade:</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $equipamento->equipamento_custo_indisponibilidade ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500 dark:text-gray-400">Criticidade Metrológica:</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $equipamento->equipamento_criticidade_metrologica ?? '-' }}</dd>
                        </div>
                    </dl>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">IGP não calculado</p>
                @endif
            </div>
        </x-card>

        <!-- Dados Financeiros -->
        @if($equipamento->valor_aquisicao || $equipamento->equipamento_custo_estimado || $equipamento->data_aquisicao)
        <x-card title="Dados Financeiros" icon="fas fa-dollar-sign">
            <dl class="space-y-3">
                @if($equipamento->valor_aquisicao)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Valor de Aquisição</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                        R$ {{ number_format($equipamento->valor_aquisicao, 2, ',', '.') }}
                    </dd>
                </div>
                @endif

                @if($equipamento->equipamento_custo_estimado)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Custo de Calibração</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                        R$ {{ number_format($equipamento->equipamento_custo_estimado, 2, ',', '.') }}
                    </dd>
                </div>
                @endif

                @if($equipamento->data_aquisicao)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data de Aquisição</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($equipamento->data_aquisicao)->format('d/m/Y') }}
                    </dd>
                </div>
                @endif
            </dl>
        </x-card>
        @endif

        <!-- Links e Documentos -->
        @if($equipamento->equipamento_link_fabricante || $equipamento->equipamento_manual_pdf || $equipamento->equipamento_certificado_pdf)
        <x-card title="Links e Documentos" icon="fas fa-link">
            <div class="space-y-2">
                @if($equipamento->equipamento_link_fabricante)
                    <a href="{{ $equipamento->equipamento_link_fabricante }}" target="_blank" class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="fas fa-external-link-alt"></i>
                        Site do Fabricante
                    </a>
                @endif

                @if($equipamento->equipamento_manual_pdf)
                    <a href="{{ asset('storage/' . $equipamento->equipamento_manual_pdf) }}" target="_blank" class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="fas fa-file-pdf"></i>
                        Manual do Equipamento
                    </a>
                @endif

                @if($equipamento->equipamento_certificado_pdf)
                    <a href="{{ asset('storage/' . $equipamento->equipamento_certificado_pdf) }}" target="_blank" class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="fas fa-certificate"></i>
                        Certificado de Calibração
                    </a>
                @endif
            </div>
        </x-card>
        @endif

    </div>

</div>
@endsection

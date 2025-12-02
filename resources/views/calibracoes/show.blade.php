@extends('layouts.app')

@section('title', 'Detalhes da Calibração - CalibSys')

@section('page-title', 'Detalhes da Calibração')

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
                <a href="{{ route('calibracoes.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    Calibrações
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Detalhes #{{ $calibracao->id }}</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-clipboard-check text-blue-600 mr-2"></i>
        Calibração #{{ $calibracao->id }}
    </h2>

    <div class="flex gap-2">
        <x-button variant="outline" icon="fas fa-arrow-left" :href="route('calibracoes.index')">
            Voltar
        </x-button>
        <x-button variant="primary" icon="fas fa-edit" :href="route('calibracoes.edit', $calibracao)">
            Editar
        </x-button>
    </div>
</div>

<!-- Informações Principais -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Equipamento -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <i class="fas fa-cog text-xl text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Equipamento</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Informações do equipamento</p>
            </div>
        </div>
        <div class="space-y-3">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Tipo</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->equipamento->equipamento_tipo ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Código Interno</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->equipamento->equipamento_codigo_interno ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Fabricante</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->equipamento->equipamento_fabricante ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Modelo</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->equipamento->equipamento_modelo ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Serial</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->equipamento->equipamento_serial ?? 'N/A' }}</p>
            </div>
            @if($calibracao->equipamento)
            <a href="{{ route('equipamentos.show', $calibracao->equipamento) }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                <i class="fas fa-external-link-alt"></i>
                Ver detalhes do equipamento
            </a>
            @endif
        </div>
    </div>

    <!-- Laboratório -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30">
                <i class="fas fa-flask text-xl text-purple-600 dark:text-purple-400"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Laboratório</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Responsável pela calibração</p>
            </div>
        </div>
        <div class="space-y-3">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Nome</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->laboratorio->nome ?? 'N/A' }}</p>
            </div>
            @if($calibracao->laboratorio && $calibracao->laboratorio->cnpj)
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">CNPJ</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->laboratorio->cnpj }}</p>
            </div>
            @endif
            @if($calibracao->laboratorio && $calibracao->laboratorio->email)
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->laboratorio->email }}</p>
            </div>
            @endif
            @if($calibracao->laboratorio && $calibracao->laboratorio->telefone)
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Telefone</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->laboratorio->telefone }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Resultado -->
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                <i class="fas fa-check-circle text-xl text-green-600 dark:text-green-400"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Resultado</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status da calibração</p>
            </div>
        </div>
        <div class="space-y-3">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                <div class="mt-1">
                    @if($calibracao->resultado === 'aprovado')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                            <i class="fas fa-check-circle mr-1"></i> Aprovado
                        </span>
                    @elseif($calibracao->resultado === 'reprovado')
                        <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800 dark:bg-red-900 dark:text-red-300">
                            <i class="fas fa-times-circle mr-1"></i> Reprovado
                        </span>
                    @elseif($calibracao->resultado === 'condicional')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                            <i class="fas fa-exclamation-circle mr-1"></i> Condicional
                        </span>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">-</span>
                    @endif
                </div>
            </div>
            @if($calibracao->certificado_num)
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Número do Certificado</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->certificado_num }}</p>
            </div>
            @endif
            @if($calibracao->arquivo_certificado)
            <div>
                <a href="{{ Storage::url($calibracao->arquivo_certificado) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    <i class="fas fa-file-pdf"></i>
                    Download Certificado
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Datas e Timeline -->
<div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
        Cronologia
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @if($calibracao->data_envio)
        <div class="border-l-4 border-blue-500 pl-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Data de Envio</p>
            <p class="text-base font-semibold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($calibracao->data_envio)->format('d/m/Y') }}
            </p>
        </div>
        @endif

        @if($calibracao->data_recebimento_lab)
        <div class="border-l-4 border-purple-500 pl-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Recebido pelo Lab</p>
            <p class="text-base font-semibold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($calibracao->data_recebimento_lab)->format('d/m/Y') }}
            </p>
        </div>
        @endif

        @if($calibracao->data_calibracao)
        <div class="border-l-4 border-green-500 pl-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Data de Calibração</p>
            <p class="text-base font-semibold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') }}
            </p>
        </div>
        @endif

        @if($calibracao->data_retorno)
        <div class="border-l-4 border-orange-500 pl-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Data de Retorno</p>
            <p class="text-base font-semibold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($calibracao->data_retorno)->format('d/m/Y') }}
            </p>
        </div>
        @endif

        @if($calibracao->data_aceitacao_et)
        <div class="border-l-4 border-teal-500 pl-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Aceitação ET</p>
            <p class="text-base font-semibold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($calibracao->data_aceitacao_et)->format('d/m/Y') }}
            </p>
        </div>
        @endif

        @if($calibracao->proxima_calibracao_sugerida)
        <div class="border-l-4 border-yellow-500 pl-4">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Próxima Sugerida</p>
            <p class="text-base font-semibold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($calibracao->proxima_calibracao_sugerida)->format('d/m/Y') }}
            </p>
        </div>
        @endif
    </div>
</div>

<!-- Informações Técnicas RBC -->
@if($calibracao->rbc_codigo_laboratorio || $calibracao->rbc_metodo_calibracao || $calibracao->rbc_incerteza_prevista)
<div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
        <i class="fas fa-certificate text-blue-600 mr-2"></i>
        Informações RBC
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if($calibracao->rbc_codigo_laboratorio)
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Código RBC</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->rbc_codigo_laboratorio }}</p>
        </div>
        @endif

        @if($calibracao->rbc_metodo_calibracao)
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Método de Calibração</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->rbc_metodo_calibracao }}</p>
        </div>
        @endif

        @if($calibracao->rbc_incerteza_prevista)
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Incerteza Prevista</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->rbc_incerteza_prevista }}</p>
        </div>
        @endif

        @if($calibracao->rbc_capacidade_medicao)
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Capacidade de Medição</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $calibracao->rbc_capacidade_medicao }}</p>
        </div>
        @endif

        @if($calibracao->conformidade_ilac_p14 !== null)
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Conformidade ILAC-P14</p>
            <p class="text-sm font-medium text-gray-900 dark:text-white">
                @if($calibracao->conformidade_ilac_p14)
                    <span class="text-green-600 dark:text-green-400">
                        <i class="fas fa-check-circle"></i> Conforme
                    </span>
                @else
                    <span class="text-red-600 dark:text-red-400">
                        <i class="fas fa-times-circle"></i> Não Conforme
                    </span>
                @endif
            </p>
        </div>
        @endif
    </div>
</div>
@endif

<!-- Custos e Responsáveis -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Custos -->
    @if($calibracao->custo)
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-dollar-sign text-blue-600 mr-2"></i>
            Custo
        </h3>
        <div class="text-3xl font-bold text-gray-900 dark:text-white">
            R$ {{ number_format($calibracao->custo, 2, ',', '.') }}
        </div>
    </div>
    @endif

    <!-- Responsável -->
    @if($calibracao->responsavel_et)
    <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-user text-blue-600 mr-2"></i>
            Responsável ET
        </h3>
        <div class="text-xl font-medium text-gray-900 dark:text-white">
            {{ $calibracao->responsavel_et }}
        </div>
    </div>
    @endif
</div>

<!-- Observações -->
@if($calibracao->observacoes)
<div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
        <i class="fas fa-comment-alt text-blue-600 mr-2"></i>
        Observações
    </h3>
    <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $calibracao->observacoes }}</div>
</div>
@endif

<!-- Informações do Sistema -->
<div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.03] p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
        Informações do Sistema
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">ID da Calibração</p>
            <p class="font-medium text-gray-900 dark:text-white">#{{ $calibracao->id }}</p>
        </div>
        @if($calibracao->created_at)
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Criado em</p>
            <p class="font-medium text-gray-900 dark:text-white">{{ $calibracao->created_at->format('d/m/Y H:i') }}</p>
        </div>
        @endif
        @if($calibracao->updated_at)
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Atualizado em</p>
            <p class="font-medium text-gray-900 dark:text-white">{{ $calibracao->updated_at->format('d/m/Y H:i') }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Ações -->
<div class="mt-6 flex gap-3">
    <form action="{{ route('calibracoes.destroy', $calibracao) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta calibração?');">
        @csrf
        @method('DELETE')
        <x-button type="submit" variant="danger" icon="fas fa-trash-alt">
            Excluir
        </x-button>
    </form>
</div>
@endsection

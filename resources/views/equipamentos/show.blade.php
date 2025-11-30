@extends('layouts.tailadmin')

@section('content')
    @php
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Equipamentos', 'url' => route('equipamentos.index')],
            ['label' => $equipamento->codigo_interno, 'url' => '']
        ];
    @endphp

    <!-- Header com Badge de Status -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold">{{ $equipamento->codigo_interno }}</h1>
                    @if($equipamento->criticidade === 'critica')
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">🔴 CRÍTICA</span>
                    @elseif($equipamento->criticidade === 'alta')
                        <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">🟠 ALTA</span>
                    @elseif($equipamento->criticidade === 'media')
                        <span class="bg-blue-400 text-white px-3 py-1 rounded-full text-xs font-semibold">🔵 MÉDIA</span>
                    @else
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">🟢 BAIXA</span>
                    @endif
                </div>
                <p class="text-indigo-100 text-lg">{{ $equipamento->tipo }} - {{ $equipamento->fabricante ?? 'N/A' }}
                </p>
                <p class="text-indigo-200 text-sm mt-1">Modelo: {{ $equipamento->modelo ?? 'N/A' }} | Série:
                    {{ $equipamento->serie ?? 'N/A' }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('equipamentos.historico', $equipamento) }}"
                    class="bg-white/20 hover:bg-white/30 backdrop-blur text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                            clip-rule="evenodd" />
                    </svg>
                    PDF
                </a>
                <a href="{{ route('equipamentos.edit', $equipamento) }}"
                    class="bg-white text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition">Editar</a>
                <a href="{{ route('equipamentos.index') }}"
                    class="bg-white/20 hover:bg-white/30 backdrop-blur text-white px-4 py-2 rounded-lg text-sm transition">Voltar</a>
            </div>
        </div>
    </div>

    <!-- Grid de 3 colunas responsivo -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Coluna 1: Info Principal -->
        <div class="space-y-4">

            <!-- Card: Identificação -->
            <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-indigo-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Identificação</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Categoria</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->categoria ?? '-' }}</span>
                    </div>
                    @if($equipamento->descricao)
                        <div class="pt-3 border-t">
                            <span class="text-gray-500 text-xs">Descrição</span>
                            <p class="text-gray-700 mt-1">{{ $equipamento->descricao }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card: Localização -->
            <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Localização</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Divisão</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->divisao_origem ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Local</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->local_fisico_atual ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Card: Calibração -->
            <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Calibração</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Ciclo</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->ciclo_meses ?? 12 }} meses</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Total</span>
                        <span
                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-bold">{{ $equipamento->calibracoes->count() }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Coluna 2: Metrologia e Foto -->
        <div class="space-y-4">

            <!-- Card: Dados Metrológicos -->
            <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-purple-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Dados Metrológicos</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Classe</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->classe_metrologica ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Resolução</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->resolucao ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Faixa</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->faixa_medicao ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">MPE</span>
                        <span class="font-semibold text-gray-800">{{ $equipamento->mpe ?? '-' }}</span>
                    </div>
                    <div class="pt-3 border-t">
                        <span class="text-gray-500 text-xs">Norma Aplicável</span>
                        <p class="text-gray-700 font-medium mt-1">{{ $equipamento->norma_aplicavel ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @if($equipamento->foto)
                <!-- Card: Foto -->
                <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="bg-pink-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800">Foto</h3>
                    </div>
                    <img src="{{ asset('storage/' . $equipamento->foto) }}" alt="Foto"
                        class="w-full rounded-lg shadow-md border border-gray-200">
                </div>
            @endif

        </div>

        <!-- Coluna 3: Históricos -->
        <div class="space-y-4">

            <!-- Card: Histórico de Calibrações -->
            <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-emerald-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Histórico de Calibrações</h3>
                </div>
                @if($equipamento->calibracoes->count() > 0)
                    <div class="space-y-2">
                        @foreach($equipamento->calibracoes->sortByDesc('data_calibracao')->take(5) as $calibracao)
                            <div
                                class="bg-gradient-to-br from-gray-50 to-gray-100 p-3 rounded-lg border border-gray-200 hover:border-emerald-300 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <span
                                        class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') }}</span>
                                    @if($calibracao->resultado === 'aprovado')
                                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">✓
                                            Aprovado</span>
                                    @elseif($calibracao->resultado === 'reprovado')
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">✗
                                            Reprovado</span>
                                    @elseif($calibracao->resultado === 'condicional')
                                        <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">!
                                            Condicional</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-600 space-y-1">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Validade: <span
                                            class="font-medium">{{ \Carbon\Carbon::parse($calibracao->data_validade)->format('d/m/Y') }}</span>
                                    </div>
                                    @if($calibracao->certificado_num)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Cert: <span class="font-medium">{{ $calibracao->certificado_num }}</span>
                                        </div>
                                    @endif
                                    @if($calibracao->laboratorio_nome)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $calibracao->laboratorio_nome }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($equipamento->calibracoes->count() > 5)
                            <div class="text-center pt-2">
                                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                    + {{ $equipamento->calibracoes->count() - 5 }} calibrações anteriores
                                </span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <svg class="w-4 h-4 mx-auto text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-400 text-xs">Nenhuma calibração registrada</p>
                    </div>
                @endif
            </div>

            <!-- Card: Histórico de Lotes -->
            <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition">
                <div class="flex items-center gap-2 mb-4">
                    <div class="bg-orange-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Histórico de Lotes</h3>
                </div>
                @if($equipamento->loteItens->count() > 0)
                    <div class="space-y-2">
                        @foreach($equipamento->loteItens->sortByDesc('loteEnvio.data_envio')->take(5) as $item)
                            <div
                                class="bg-gradient-to-br from-orange-50 to-yellow-50 p-3 rounded-lg border border-orange-200 hover:border-orange-400 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-bold text-gray-700">Lote #{{ $item->lote_envio_id }}</span>
                                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ ucfirst(str_replace('_', ' ', $item->loteEnvio->status)) }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-600 space-y-1">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Envio: <span
                                            class="font-medium">{{ \Carbon\Carbon::parse($item->loteEnvio->data_envio)->format('d/m/Y') }}</span>
                                    </div>
                                    @if($item->loteEnvio->laboratorio)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $item->loteEnvio->laboratorio->nome }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if($equipamento->loteItens->count() > 5)
                            <div class="text-center pt-2">
                                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                    + {{ $equipamento->loteItens->count() - 5 }} lotes anteriores
                                </span>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <svg class="w-4 h-4 mx-auto text-gray-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p class="text-gray-400 text-xs">Não incluído em lotes</p>
                    </div>
                @endif
            </div>

        </div>
@endsection
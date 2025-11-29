@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header compacto -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ $equipamento->codigo_interno }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('equipamentos.historico', $equipamento) }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                    </svg>
                    PDF
                </a>
                <a href="{{ route('equipamentos.edit', $equipamento) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">Editar</a>
                <a href="{{ route('equipamentos.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm">Voltar</a>
            </div>
        </div>

        <!-- Grid de 2 colunas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            
            <!-- Coluna Esquerda -->
            <div class="space-y-4">
                
                <!-- Card: Identificação -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-3 pb-2 border-b">📋 Identificação</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Tipo:</span>
                            <p class="font-medium">{{ $equipamento->tipo }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Categoria:</span>
                            <p class="font-medium">{{ $equipamento->categoria ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Fabricante:</span>
                            <p class="font-medium">{{ $equipamento->fabricante ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Modelo:</span>
                            <p class="font-medium">{{ $equipamento->modelo ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">N° Série:</span>
                            <p class="font-medium">{{ $equipamento->serie ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Criticidade:</span>
                            <p>
                                @if($equipamento->criticidade === 'critica')
                                    <span class="bg-red-500 text-white px-2 py-0.5 rounded text-xs">Crítica</span>
                                @elseif($equipamento->criticidade === 'alta')
                                    <span class="bg-orange-500 text-white px-2 py-0.5 rounded text-xs">Alta</span>
                                @elseif($equipamento->criticidade === 'media')
                                    <span class="bg-blue-500 text-white px-2 py-0.5 rounded text-xs">Média</span>
                                @else
                                    <span class="bg-gray-500 text-white px-2 py-0.5 rounded text-xs">Baixa</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @if($equipamento->descricao)
                        <div class="mt-3 pt-3 border-t">
                            <span class="text-gray-600 text-sm">Descrição:</span>
                            <p class="text-sm mt-1">{{ $equipamento->descricao }}</p>
                        </div>
                    @endif
                </div>

                <!-- Card: Localização -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-3 pb-2 border-b">📍 Localização</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Divisão:</span>
                            <p class="font-medium">{{ $equipamento->divisao_origem ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Local Atual:</span>
                            <p class="font-medium">{{ $equipamento->local_fisico_atual ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Calibração -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-3 pb-2 border-b">⏰ Calibração</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Ciclo:</span>
                            <p class="font-medium">{{ $equipamento->ciclo_meses ?? 12 }} meses</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Calibrações:</span>
                            <p class="font-medium">{{ $equipamento->calibracoes->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Dados Metrológicos -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-3 pb-2 border-b">🔬 Dados Metrológicos</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Classe:</span>
                            <p class="font-medium">{{ $equipamento->classe_metrologica ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Resolução:</span>
                            <p class="font-medium">{{ $equipamento->resolucao ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Faixa:</span>
                            <p class="font-medium">{{ $equipamento->faixa_medicao ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">MPE:</span>
                            <p class="font-medium">{{ $equipamento->mpe ?? '-' }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-600">Norma:</span>
                            <p class="font-medium">{{ $equipamento->norma_aplicavel ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                @if($equipamento->foto)
                    <!-- Card: Foto -->
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 mb-3 pb-2 border-b">📷 Foto</h3>
                        <img src="{{ asset('storage/' . $equipamento->foto) }}" alt="Foto" class="w-full rounded shadow">
                    </div>
                @endif

            </div>

            <!-- Coluna Direita -->
            <div class="space-y-4">
                
                <!-- Card: Histórico de Calibrações -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-3 pb-2 border-b">📊 Histórico de Calibrações</h3>
                    @if($equipamento->calibracoes->count() > 0)
                        <div class="space-y-2">
                            @foreach($equipamento->calibracoes->sortByDesc('data_calibracao')->take(5) as $calibracao)
                                <div class="bg-gray-50 p-3 rounded text-sm">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') }}</span>
                                        @if($calibracao->resultado === 'aprovado')
                                            <span class="bg-green-500 text-white px-2 py-0.5 rounded text-xs">Aprovado</span>
                                        @elseif($calibracao->resultado === 'reprovado')
                                            <span class="bg-red-500 text-white px-2 py-0.5 rounded text-xs">Reprovado</span>
                                        @elseif($calibracao->resultado === 'condicional')
                                            <span class="bg-yellow-500 text-white px-2 py-0.5 rounded text-xs">Condicional</span>
                                        @endif
                                    </div>
                                    <div class="text-gray-600">
                                        <div>Validade: {{ \Carbon\Carbon::parse($calibracao->data_validade)->format('d/m/Y') }}</div>
                                        @if($calibracao->certificado_num)
                                            <div>Cert: {{ $calibracao->certificado_num }}</div>
                                        @endif
                                        @if($calibracao->laboratorio_nome)
                                            <div>Lab: {{ $calibracao->laboratorio_nome }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @if($equipamento->calibracoes->count() > 5)
                                <p class="text-xs text-gray-500 text-center mt-2">
                                    + {{ $equipamento->calibracoes->count() - 5 }} calibrações anteriores
                                </p>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">Nenhuma calibração registrada</p>
                    @endif
                </div>

                <!-- Card: Histórico de Lotes -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="font-semibold text-gray-700 mb-3 pb-2 border-b">📦 Histórico de Lotes</h3>
                    @if($equipamento->loteItens->count() > 0)
                        <div class="space-y-2">
                            @foreach($equipamento->loteItens->sortByDesc('loteEnvio.data_envio')->take(5) as $item)
                                <div class="bg-gray-50 p-3 rounded text-sm">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="font-medium">Lote #{{ $item->lote_envio_id }}</span>
                                        <span class="bg-blue-500 text-white px-2 py-0.5 rounded text-xs">
                                            {{ ucfirst(str_replace('_', ' ', $item->loteEnvio->status)) }}
                                        </span>
                                    </div>
                                    <div class="text-gray-600">
                                        <div>Envio: {{ \Carbon\Carbon::parse($item->loteEnvio->data_envio)->format('d/m/Y') }}</div>
                                        @if($item->loteEnvio->laboratorio)
                                            <div>Lab: {{ $item->loteEnvio->laboratorio->nome }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @if($equipamento->loteItens->count() > 5)
                                <p class="text-xs text-gray-500 text-center mt-2">
                                    + {{ $equipamento->loteItens->count() - 5 }} lotes anteriores
                                </p>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">Não incluído em lotes</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
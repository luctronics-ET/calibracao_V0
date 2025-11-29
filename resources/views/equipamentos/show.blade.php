@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalhes do Equipamento</h1>
                <div class="flex gap-2">
                    <a href="{{ route('equipamentos.historico', $equipamento) }}"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                        </svg>
                        Histórico PDF
                    </a>
                    <a href="{{ route('equipamentos.edit', $equipamento) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Editar
                    </a>
                    <a href="{{ route('equipamentos.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Informações Básicas -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Informações Básicas</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Código Interno</p>
                        <p class="text-lg">{{ $equipamento->codigo_interno }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Tipo</p>
                        <p class="text-lg">{{ $equipamento->tipo }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Categoria</p>
                        <p class="text-lg">{{ $equipamento->categoria ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Fabricante</p>
                        <p class="text-lg">{{ $equipamento->fabricante ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Modelo</p>
                        <p class="text-lg">{{ $equipamento->modelo ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Número de Série</p>
                        <p class="text-lg">{{ $equipamento->serie ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Divisão de Origem</p>
                        <p class="text-lg">{{ $equipamento->divisao_origem ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Local Físico Atual</p>
                        <p class="text-lg">{{ $equipamento->local_fisico_atual ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Criticidade</p>
                        <p class="text-lg">
                            @if($equipamento->criticidade === 'critica')
                                <span class="inline-block bg-red-500 text-white px-3 py-1 rounded">Crítica</span>
                            @elseif($equipamento->criticidade === 'alta')
                                <span class="inline-block bg-orange-500 text-white px-3 py-1 rounded">Alta</span>
                            @elseif($equipamento->criticidade === 'media')
                                <span class="inline-block bg-blue-500 text-white px-3 py-1 rounded">Média</span>
                            @else
                                <span class="inline-block bg-gray-500 text-white px-3 py-1 rounded">Baixa</span>
                            @endif
                        </p>
                    </div>
                    @if($equipamento->descricao)
                        <div class="col-span-3">
                            <p class="text-sm text-gray-600 font-semibold">Descrição</p>
                            <p class="text-lg">{{ $equipamento->descricao }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Dados de Calibração -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Dados de Calibração</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Ciclo de Calibração</p>
                        <p class="text-lg">{{ $equipamento->ciclo_meses ?? 12 }} meses</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Total de Calibrações</p>
                        <p class="text-lg">{{ $equipamento->calibracoes->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Dados Metrológicos -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Dados Metrológicos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Classe Metrológica</p>
                        <p class="text-lg">{{ $equipamento->classe_metrologica ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Resolução</p>
                        <p class="text-lg">{{ $equipamento->resolucao ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Faixa de Medição</p>
                        <p class="text-lg">{{ $equipamento->faixa_medicao ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">MPE (Máximo Erro Permitido)</p>
                        <p class="text-lg">{{ $equipamento->mpe ?? '-' }}</p>
                    </div>
                    @if($equipamento->foto)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 font-semibold mb-2">📷 Foto do Equipamento</p>
                            <img src="{{ asset('storage/' . $equipamento->foto) }}" alt="Foto do equipamento" class="max-w-md rounded shadow-lg">
                        </div>
                    @endif
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 font-semibold">Norma Aplicável</p>
                        <p class="text-lg">{{ $equipamento->norma_aplicavel ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Histórico de Calibrações -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Histórico de Calibrações</h2>
                @if($equipamento->calibracoes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Data Calibração</th>
                                    <th class="px-4 py-2 text-left">Data Validade</th>
                                    <th class="px-4 py-2 text-left">Certificado</th>
                                    <th class="px-4 py-2 text-left">Laboratório</th>
                                    <th class="px-4 py-2 text-left">Resultado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipamento->calibracoes->sortByDesc('data_calibracao') as $calibracao)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">
                                            {{ \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            {{ \Carbon\Carbon::parse($calibracao->data_validade)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">{{ $calibracao->certificado_num ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $calibracao->laboratorio_nome ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            @if($calibracao->resultado === 'aprovado')
                                                <span
                                                    class="inline-block bg-green-500 text-white px-2 py-1 rounded text-sm">Aprovado</span>
                                            @elseif($calibracao->resultado === 'reprovado')
                                                <span
                                                    class="inline-block bg-red-500 text-white px-2 py-1 rounded text-sm">Reprovado</span>
                                            @elseif($calibracao->resultado === 'condicional')
                                                <span
                                                    class="inline-block bg-yellow-500 text-white px-2 py-1 rounded text-sm">Condicional</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Nenhuma calibração registrada para este equipamento.</p>
                @endif
            </div>

            <!-- Histórico de Lotes -->
            <div class="bg-white shadow-md rounded px-8 py-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Histórico de Lotes</h2>
                @if($equipamento->loteItens->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Lote</th>
                                    <th class="px-4 py-2 text-left">Data Envio</th>
                                    <th class="px-4 py-2 text-left">Laboratório</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($equipamento->loteItens->sortByDesc('loteEnvio.data_envio') as $item)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">Lote #{{ $item->lote_envio_id }}</td>
                                        <td class="px-4 py-2">
                                            {{ \Carbon\Carbon::parse($item->loteEnvio->data_envio)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">{{ $item->loteEnvio->laboratorio->nome ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            <span
                                                class="inline-block bg-blue-500 text-white px-2 py-1 rounded text-sm">{{ ucfirst(str_replace('_', ' ', $item->loteEnvio->status)) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Este equipamento não foi incluído em nenhum lote.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
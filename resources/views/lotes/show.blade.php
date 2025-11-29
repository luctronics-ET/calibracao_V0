@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalhes do Lote #{{ $lote->id }}</h1>
                <div class="flex gap-2">
                    <a href="{{ route('lotes.pdf', $lote) }}"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                clip-rule="evenodd" />
                        </svg>
                        Lista PDF
                    </a>
                    <a href="{{ route('lotes.edit', $lote) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Editar
                    </a>
                    <a href="{{ route('lotes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Informações do Lote -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Informações do Lote</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Laboratório</p>
                        <p class="text-lg">
                            <a href="{{ route('laboratorios.show', $lote->laboratorio) }}"
                                class="text-blue-600 hover:underline">
                                {{ $lote->laboratorio->nome }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Data de Envio</p>
                        <p class="text-lg">{{ \Carbon\Carbon::parse($lote->data_envio)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Status</p>
                        <p class="text-lg">
                            @if($lote->status === 'preparacao')
                                <span class="inline-block bg-gray-500 text-white px-3 py-1 rounded">Em Preparação</span>
                            @elseif($lote->status === 'enviado')
                                <span class="inline-block bg-blue-500 text-white px-3 py-1 rounded">Enviado</span>
                            @elseif($lote->status === 'em_calibracao')
                                <span class="inline-block bg-yellow-500 text-white px-3 py-1 rounded">Em Calibração</span>
                            @elseif($lote->status === 'concluido')
                                <span class="inline-block bg-green-500 text-white px-3 py-1 rounded">Concluído</span>
                            @else
                                <span class="inline-block bg-red-500 text-white px-3 py-1 rounded">Cancelado</span>
                            @endif
                        </p>
                    </div>
                    @if($lote->data_prev_retorno)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Previsão de Retorno</p>
                            <p class="text-lg">{{ \Carbon\Carbon::parse($lote->data_prev_retorno)->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($lote->data_retorno)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Data de Retorno</p>
                            <p class="text-lg">{{ \Carbon\Carbon::parse($lote->data_retorno)->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($lote->contrato)
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Contrato</p>
                            <p class="text-lg">{{ $lote->contrato->edital_num ?? '-' }}</p>
                        </div>
                    @endif
                    @if($lote->observacoes)
                        <div class="col-span-3">
                            <p class="text-sm text-gray-600 font-semibold">Observações</p>
                            <p class="text-lg">{{ $lote->observacoes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Itens do Lote -->
            <div class="bg-white shadow-md rounded px-8 py-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Equipamentos no Lote</h2>
                @if($lote->itens && $lote->itens->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Código</th>
                                    <th class="px-4 py-2 text-left">Tipo</th>
                                    <th class="px-4 py-2 text-left">Fabricante</th>
                                    <th class="px-4 py-2 text-left">Modelo</th>
                                    <th class="px-4 py-2 text-left">Série</th>
                                    <th class="px-4 py-2 text-left">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lote->itens as $item)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">
                                            <a href="{{ route('equipamentos.show', $item->equipamento) }}"
                                                class="text-blue-600 hover:underline">
                                                {{ $item->equipamento->codigo_interno }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-2">{{ $item->equipamento->tipo }}</td>
                                        <td class="px-4 py-2">{{ $item->equipamento->fabricante ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $item->equipamento->modelo ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $item->equipamento->serie ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('equipamentos.show', $item->equipamento) }}"
                                                class="text-blue-600 hover:underline text-sm">
                                                Ver Detalhes
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            <strong>Total de equipamentos:</strong> {{ $lote->itens->count() }}
                        </p>
                    </div>
                @else
                    <p class="text-gray-500">Nenhum equipamento adicionado a este lote.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
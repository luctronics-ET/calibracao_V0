@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalhes da Calibração</h1>
                <div class="flex gap-2">
                    <a href="{{ route('calibracoes.certificado', $calibracao) }}"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                clip-rule="evenodd" />
                        </svg>
                        Certificado PDF
                    </a>
                    <a href="{{ route('calibracoes.edit', $calibracao) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Editar
                    </a>
                    <a href="{{ route('calibracoes.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Informações Principais -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Informações da Calibração</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Equipamento</p>
                        <p class="text-lg">
                            <a href="{{ route('equipamentos.show', $calibracao->equipamento) }}"
                                class="text-blue-600 hover:underline">
                                {{ $calibracao->equipamento->codigo_interno }} - {{ $calibracao->equipamento->tipo }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Número do Certificado</p>
                        <p class="text-lg">{{ $calibracao->certificado_num ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Data de Calibração</p>
                        <p class="text-lg">{{ \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Data de Validade</p>
                        <p class="text-lg">{{ \Carbon\Carbon::parse($calibracao->data_validade)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Laboratório</p>
                        <p class="text-lg">{{ $calibracao->laboratorio_nome ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Resultado</p>
                        <p class="text-lg">
                            @if($calibracao->resultado === 'aprovado')
                                <span class="inline-block bg-green-500 text-white px-3 py-1 rounded">Aprovado</span>
                            @elseif($calibracao->resultado === 'reprovado')
                                <span class="inline-block bg-red-500 text-white px-3 py-1 rounded">Reprovado</span>
                            @elseif($calibracao->resultado === 'condicional')
                                <span class="inline-block bg-yellow-500 text-white px-3 py-1 rounded">Condicional</span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    @if($calibracao->observacoes)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 font-semibold">Observações</p>
                            <p class="text-lg">{{ $calibracao->observacoes }}</p>
                        </div>
                    @endif
                    @if($calibracao->arquivo_certificado)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 font-semibold mb-2">📄 Certificado de Calibração</p>
                            <a href="{{ asset('storage/' . $calibracao->arquivo_certificado) }}" target="_blank"
                                class="inline-block bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                📥 Baixar Certificado (PDF)
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Parâmetros Metrológicos -->
            @if($calibracao->parametrosMetrologicos && $calibracao->parametrosMetrologicos->count() > 0)
                <div class="bg-white shadow-md rounded px-8 py-6">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Parâmetros Metrológicos</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Parâmetro</th>
                                    <th class="px-4 py-2 text-left">Valor Nominal</th>
                                    <th class="px-4 py-2 text-left">Valor Medido</th>
                                    <th class="px-4 py-2 text-left">Incerteza</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calibracao->parametrosMetrologicos as $parametro)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $parametro->parametro }}</td>
                                        <td class="px-4 py-2">{{ $parametro->valor_nominal }} {{ $parametro->unidade }}</td>
                                        <td class="px-4 py-2">{{ $parametro->valor_medido }} {{ $parametro->unidade }}</td>
                                        <td class="px-4 py-2">{{ $parametro->incerteza ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
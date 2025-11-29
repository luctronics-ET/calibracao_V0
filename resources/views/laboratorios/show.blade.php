@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalhes do Laboratório</h1>
                <div class="flex gap-2">
                    <a href="{{ route('laboratorios.edit', $laboratorio) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Editar
                    </a>
                    <a href="{{ route('laboratorios.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Informações do Laboratório -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Informações do Laboratório</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 font-semibold">Nome</p>
                        <p class="text-lg">{{ $laboratorio->nome }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">CNPJ</p>
                        <p class="text-lg">{{ $laboratorio->cnpj ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Contato</p>
                        <p class="text-lg">{{ $laboratorio->contato ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 font-semibold">Endereço</p>
                        <p class="text-lg">{{ $laboratorio->endereco ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Acreditação</p>
                        <p class="text-lg">
                            @if($laboratorio->acreditado)
                                <span class="inline-block bg-green-500 text-white px-3 py-1 rounded">Acreditado</span>
                            @else
                                <span class="inline-block bg-gray-500 text-white px-3 py-1 rounded">Não Acreditado</span>
                            @endif
                        </p>
                    </div>
                    @if($laboratorio->escopo)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 font-semibold">Escopo de Acreditação</p>
                            <p class="text-lg whitespace-pre-line">{{ $laboratorio->escopo }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contratos -->
            @if($laboratorio->contratos && $laboratorio->contratos->count() > 0)
                <div class="bg-white shadow-md rounded px-8 py-6 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Contratos</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">Edital</th>
                                    <th class="px-4 py-2 text-left">Vigência Início</th>
                                    <th class="px-4 py-2 text-left">Vigência Fim</th>
                                    <th class="px-4 py-2 text-left">Preço Unitário</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laboratorio->contratos as $contrato)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $contrato->edital_num ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            {{ $contrato->vigencia_ini ? \Carbon\Carbon::parse($contrato->vigencia_ini)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $contrato->vigencia_fim ? \Carbon\Carbon::parse($contrato->vigencia_fim)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-2">R$ {{ number_format($contrato->preco_unitario ?? 0, 2, ',', '.') }}
                                        </td>
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
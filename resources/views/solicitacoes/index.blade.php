@extends('layouts.app')
@section('title', 'Solicitações - CalibSys')
@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold"><i class="fas fa-clipboard-list text-blue-600 mr-2"></i>Solicitações de Serviço</h2>
    <x-button variant="primary" icon="fas fa-plus" :href="route('solicitacoes.create')">Nova Solicitação</x-button>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <x-card><div class="text-3xl font-bold">{{ $solicitacoes->total() }}</div><p class="text-gray-500">Total</p></x-card>
    <x-card><div class="text-3xl font-bold text-yellow-600">{{ $solicitacoes->where('status', 'pendente')->count() }}</div><p class="text-gray-500">Pendentes</p></x-card>
    <x-card><div class="text-3xl font-bold text-blue-600">{{ $solicitacoes->where('status', 'em_andamento')->count() }}</div><p class="text-gray-500">Em Andamento</p></x-card>
    <x-card><div class="text-3xl font-bold text-green-600">{{ $solicitacoes->where('status', 'concluida')->count() }}</div><p class="text-gray-500">Concluídas</p></x-card>
</div>

<x-datatable3
    id="solicitacoesTable"
    title=""
    :headers="['ID', 'Solicitante', 'Tipo', 'Data', 'Status', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#solicitacoesTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#solicitacoesTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
        @foreach($solicitacoes as $s)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-6 py-4">{{ $s->id }}</td>
            <td class="px-6 py-4">{{ $s->solicitante }}</td>
            <td class="px-6 py-4">{{ $s->tipo_servico ?? '-' }}</td>
            <td class="px-6 py-4">{{ $s->data_solicitacao ? $s->data_solicitacao->format('d/m/Y') : '-' }}</td>
            <td class="px-6 py-4">
                @if($s->status === 'concluida')
                    <x-badge variant="success">Concluída</x-badge>
                @elseif($s->status === 'em_andamento')
                    <x-badge variant="primary">Em Andamento</x-badge>
                @else
                    <x-badge variant="warning">Pendente</x-badge>
                @endif
            </td>
            <td class="px-6 py-4">
                <div class="flex gap-2">
                    <a href="{{ route('solicitacoes.show', $s) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('solicitacoes.edit', $s) }}" class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-edit"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-datatable3>
@endsection

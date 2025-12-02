@extends('layouts.app')
@section('title', 'Transportes - CalibSys')
@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold"><i class="fas fa-truck text-blue-600 mr-2"></i>Transportadoras</h2>
    <x-button variant="primary" icon="fas fa-plus" :href="route('transportes.create')">Nova Transportadora</x-button>
</div>

<x-datatable3
    id="transportesTable"
    title=""
    :headers="['ID', 'Transportadora', 'Motorista', 'Veículo', 'Documento', 'Contato', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#transportesTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#transportesTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
        @foreach($transportes as $t)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-6 py-4">{{ $t->id }}</td>
            <td class="px-6 py-4 font-semibold">{{ $t->transportadora }}</td>
            <td class="px-6 py-4">{{ $t->motorista ?? '-' }}</td>
            <td class="px-6 py-4">{{ $t->veiculo ?? '-' }}</td>
            <td class="px-6 py-4">{{ $t->documento_transporte ?? '-' }}</td>
            <td class="px-6 py-4">{{ $t->contato ?? '-' }}</td>
            <td class="px-6 py-4">
                <div class="flex gap-2">
                    <a href="{{ route('transportes.show', $t) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('transportes.edit', $t) }}" class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-edit"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-datatable3>
@endsection

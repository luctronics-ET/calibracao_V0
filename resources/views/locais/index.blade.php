@extends('layouts.app')
@section('title', 'Locais - CalibSys')
@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold"><i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Locais e Localizações</h2>
    <x-button variant="primary" icon="fas fa-plus" :href="route('locais.create')">Novo Local</x-button>
</div>

<x-datatable3
    id="locaisTable"
    title=""
    :headers="['ID', 'Nome', 'Tipo', 'Referência', 'Contato', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#locaisTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#locaisTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
        @foreach($locais as $l)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-6 py-4">{{ $l->id }}</td>
            <td class="px-6 py-4 font-semibold">{{ $l->nome }}</td>
            <td class="px-6 py-4"><x-badge variant="primary">{{ $l->tipo ?? '-' }}</x-badge></td>
            <td class="px-6 py-4">{{ $l->referencia ?? '-' }}</td>
            <td class="px-6 py-4">{{ $l->contato ?? '-' }}</td>
            <td class="px-6 py-4">
                <div class="flex gap-2">
                    <a href="{{ route('locais.show', $l) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('locais.edit', $l) }}" class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-edit"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-datatable3>
@endsection

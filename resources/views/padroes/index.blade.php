@extends('layouts.app')
@section('title', 'Padrões RBC - CalibSys')
@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold"><i class="fas fa-award text-blue-600 mr-2"></i>Padrões de Medição RBC</h2>
    <x-button variant="primary" icon="fas fa-plus" :href="route('padroes.create')">Novo Padrão</x-button>
</div>

<x-datatable3
    id="padroesTable"
    title=""
    :headers="['ID', 'Nome', 'Modelo', 'Fabricante', 'Nº Série', 'Código RBC', 'Validade', 'Ações']"
    :searchable="true"
    :exportable="true"
>
    <x-slot name="actions">
        <button onclick="$('#padroesTable').DataTable().button('.buttons-excel').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
            <i class="fas fa-file-excel"></i>
            Excel
        </button>
        <button onclick="$('#padroesTable').DataTable().button('.buttons-pdf').trigger()" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
            <i class="fas fa-file-pdf"></i>
            PDF
        </button>
    </x-slot>

    <x-slot name="body">
        @foreach($padroes as $p)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
            <td class="px-6 py-4">{{ $p->id }}</td>
            <td class="px-6 py-4 font-semibold">{{ $p->nome }}</td>
            <td class="px-6 py-4">{{ $p->modelo ?? '-' }}</td>
            <td class="px-6 py-4">{{ $p->fabricante ?? '-' }}</td>
            <td class="px-6 py-4">{{ $p->numero_serie ?? '-' }}</td>
            <td class="px-6 py-4">{{ $p->rbc_codigo_laboratorio ?? '-' }}</td>
            <td class="px-6 py-4">
                @if($p->validade_certificado)
                    @php
                        $diff = now()->diffInDays($p->validade_certificado, false);
                        $color = $diff < 0 ? 'text-red-600' : ($diff < 30 ? 'text-yellow-600' : 'text-green-600');
                    @endphp
                    <span class="{{ $color }}">{{ $p->validade_certificado->format('d/m/Y') }}</span>
                @else
                    -
                @endif
            </td>
            <td class="px-6 py-4">
                <div class="flex gap-2">
                    <a href="{{ route('padroes.show', $p) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('padroes.edit', $p) }}" class="text-yellow-600 hover:text-yellow-900"><i class="fas fa-edit"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </x-slot>
</x-datatable3>
@endsection

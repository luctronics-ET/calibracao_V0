@extends('layouts.app')
@section('title', 'Histórico - CalibSys')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        <i class="fas fa-history text-blue-600 mr-2"></i>
        Histórico de Calibrações
    </h2>
</div>

<x-card title="Em desenvolvimento" icon="fas fa-info-circle">
    <p class="text-gray-600 dark:text-gray-400">
        Este relatório está sendo desenvolvido e estará disponível em breve.
    </p>
    <div class="mt-4">
        <x-button variant="outline" icon="fas fa-arrow-left" :href="route('reports.index')">Voltar</x-button>
    </div>
</x-card>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Calibração')

@section('content')
<div class="grid">
    <div class="stat-card">
        <h3>Total de Equipamentos</h3>
        <div class="value">{{ $totalEquipamentos ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Calibrações Ativas</h3>
        <div class="value">{{ $calibracoesAtivas ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Lotes em Andamento</h3>
        <div class="value">{{ $lotesAndamento ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Laboratórios</h3>
        <div class="value">{{ $totalLaboratorios ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Equipamentos Vencidos</h3>
        <div class="value" style="color:#dc2626;">{{ $vencidos ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Próx. {{ $janelaDias ?? 30 }} dias</h3>
        <div class="value" style="color:#d97706;">{{ $proximos ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Sem Calibração</h3>
        <div class="value" style="color:#6b7280;">{{ $semCalibracao ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Gasto Mês</h3>
        <div class="value">R$ {{ number_format($gastoMes ?? 0, 2, ',', '.') }}</div>
    </div>
    <div class="stat-card">
        <h3>Gasto Ano</h3>
        <div class="value">R$ {{ number_format($gastoAno ?? 0, 2, ',', '.') }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>📊 Visão Geral do Sistema</h2>
    </div>
    <div style="text-align: center; padding: 2rem;">
        <h3 style="color: #667eea; margin-bottom: 1rem;">Sistema de Calibração</h3>
        <p style="color: #6b7280; margin-bottom: 2rem;">Laravel {{ app()->version() }} + Vue 3 + SQLite</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="/equipamentos" class="btn btn-primary">📋 Gerenciar Equipamentos</a>
            <a href="/calibracoes" class="btn btn-success">🔬 Calibrações</a>
            <a href="/lotes" class="btn btn-primary">📦 Lotes de Envio</a>
        </div>
    </div>
</div>

<div class="card" style="margin-top:1rem;">
    <div class="card-header">
        <h3>Distribuição por Criticidade</h3>
    </div>
    <div style="display:flex; gap:1rem; justify-content:center; padding:1rem; flex-wrap:wrap;">
        @php($pc = $porCriticidade ?? [])
        <div class="stat-card">
            <h4>Crítica</h4>
            <div class="value" style="color:#dc2626;">{{ $pc['critica'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h4>Alta</h4>
            <div class="value" style="color:#d97706;">{{ $pc['alta'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h4>Média</h4>
            <div class="value" style="color:#2563eb;">{{ $pc['media'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h4>Baixa</h4>
            <div class="value" style="color:#10b981;">{{ $pc['baixa'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <h4>Indef.</h4>
            <div class="value" style="color:#6b7280;">{{ $pc['indefinida'] ?? 0 }}</div>
        </div>
    </div>
</div>
@endsection
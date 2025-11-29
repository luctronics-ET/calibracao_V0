@extends('layouts.app')

@section('title', 'Calibrações - Sistema de Calibração')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>🔬 Calibrações</h2>
        <a href="/calibracoes/create" class="btn btn-primary">+ Nova Calibração</a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipamento</th>
                <th>Laboratório</th>
                <th>Data Envio</th>
                <th>Data Retorno</th>
                <th>Status</th>
                <th>Resultado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($calibracoes ?? [] as $calibracao)
            <tr>
                <td>{{ $calibracao->id }}</td>
                <td>{{ $calibracao->equipamento->patrimonio ?? 'N/A' }}</td>
                <td>{{ $calibracao->laboratorio->nome ?? 'N/A' }}</td>
                <td>{{ $calibracao->data_envio ? \Carbon\Carbon::parse($calibracao->data_envio)->format('d/m/Y') : '-' }}</td>
                <td>{{ $calibracao->data_retorno ? \Carbon\Carbon::parse($calibracao->data_retorno)->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($calibracao->status === 'concluida')
                        <span class="badge badge-success">Concluída</span>
                    @elseif($calibracao->status === 'em_processo')
                        <span class="badge badge-info">Em Processo</span>
                    @else
                        <span class="badge badge-warning">Pendente</span>
                    @endif
                </td>
                <td>
                    @if($calibracao->resultado === 'aprovado')
                        <span class="badge badge-success">✓ Aprovado</span>
                    @elseif($calibracao->resultado === 'reprovado')
                        <span class="badge badge-danger">✗ Reprovado</span>
                    @else
                        <span class="badge badge-warning">Pendente</span>
                    @endif
                </td>
                <td>
                    <a href="/calibracoes/{{ $calibracao->id }}" class="btn btn-sm btn-primary">Ver</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">
                    Nenhuma calibração registrada. <a href="/calibracoes/create">Registre a primeira</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Equipamentos - Sistema de Calibração')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>📋 Equipamentos</h2>
        <a href="/equipamentos/create" class="btn btn-primary">+ Novo Equipamento</a>
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
                <th>Patrimônio</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipamentos ?? [] as $equipamento)
            <tr>
                <td>{{ $equipamento->id }}</td>
                <td><strong>{{ $equipamento->patrimonio }}</strong></td>
                <td>{{ $equipamento->tipo }}</td>
                <td>{{ $equipamento->marca }}</td>
                <td>{{ $equipamento->modelo }}</td>
                <td>
                    @if($equipamento->status === 'operacional')
                        <span class="badge badge-success">Operacional</span>
                    @elseif($equipamento->status === 'manutencao')
                        <span class="badge badge-warning">Manutenção</span>
                    @else
                        <span class="badge badge-danger">Inativo</span>
                    @endif
                </td>
                <td>
                    <a href="/equipamentos/{{ $equipamento->id }}" class="btn btn-sm btn-primary">Ver</a>
                    <a href="/equipamentos/{{ $equipamento->id }}/edit" class="btn btn-sm btn-success">Editar</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                    Nenhum equipamento cadastrado. <a href="/equipamentos/create">Cadastre o primeiro</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

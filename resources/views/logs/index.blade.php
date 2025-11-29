@extends('layouts.app')

@section('title', 'Logs de Auditoria')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>📋 Logs de Auditoria</h2>
        </div>

        <form method="GET" action="{{ route('logs.index') }}" class="filter-form">
            <div class="form-row">
                <select name="tabela">
                    <option value="">Tabela (todas)</option>
                    <option value="equipamentos" {{ request('tabela') === 'equipamentos' ? 'selected' : '' }}>Equipamentos
                    </option>
                    <option value="calibracoes" {{ request('tabela') === 'calibracoes' ? 'selected' : '' }}>Calibrações
                    </option>
                    <option value="lotes_envio" {{ request('tabela') === 'lotes_envio' ? 'selected' : '' }}>Lotes</option>
                    <option value="laboratorios" {{ request('tabela') === 'laboratorios' ? 'selected' : '' }}>Laboratórios
                    </option>
                </select>
                <select name="acao">
                    <option value="">Ação (todas)</option>
                    <option value="create" {{ request('acao') === 'create' ? 'selected' : '' }}>Criar</option>
                    <option value="update" {{ request('acao') === 'update' ? 'selected' : '' }}>Atualizar</option>
                    <option value="delete" {{ request('acao') === 'delete' ? 'selected' : '' }}>Excluir</option>
                </select>
                <input type="date" name="from" value="{{ request('from') }}" placeholder="Data início" />
                <input type="date" name="to" value="{{ request('to') }}" placeholder="Data fim" />
                <button type="submit" class="btn">Filtrar</button>
                @if(request()->hasAny(['tabela', 'acao', 'from', 'to']))
                    <a href="{{ route('logs.index') }}" class="btn btn-secondary">Limpar</a>
                @endif
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 12%;">Data/Hora</th>
                    <th style="width: 12%;">Tabela</th>
                    <th style="width: 8%;">Ação</th>
                    <th style="width: 10%;">Registro</th>
                    <th style="width: 15%;">Usuário</th>
                    <th style="width: 12%;">IP</th>
                    <th style="width: 8%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs ?? [] as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
                            @if($log->tabela === 'equipamentos')
                                <span class="badge badge-info">Equipamentos</span>
                            @elseif($log->tabela === 'calibracoes')
                                <span class="badge badge-warning">Calibrações</span>
                            @elseif($log->tabela === 'lotes_envio')
                                <span class="badge badge-primary">Lotes</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($log->tabela) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($log->acao === 'create')
                                <span class="badge badge-success">Criar</span>
                            @elseif($log->acao === 'update')
                                <span class="badge badge-warning">Atualizar</span>
                            @elseif($log->acao === 'delete')
                                <span class="badge badge-danger">Excluir</span>
                            @else
                                {{ ucfirst($log->acao) }}
                            @endif
                        </td>
                        <td>#{{ $log->registro_id }}</td>
                        <td>{{ $log->usuario->name ?? 'Sistema' }}</td>
                        <td><code style="font-size: 11px;">{{ $log->ip }}</code></td>
                        <td>
                            <a href="{{ route('logs.show', $log) }}" class="btn btn-sm btn-primary">Detalhes</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum log de auditoria registrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
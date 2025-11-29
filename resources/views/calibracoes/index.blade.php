@extends('layouts.app')

@section('title', 'Calibrações - Sistema de Calibração')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>🔬 Calibrações</h2>
            <div>
                <a href="{{ route('calibracoes.export', request()->all()) }}" class="btn btn-success">📊 Exportar Excel</a>
                <a href="/calibracoes/create" class="btn btn-primary">+ Nova Calibração</a>
            </div>
        </div>
        <form method="GET" action="{{ route('calibracoes.index') }}" class="filter-form">
            <div class="form-row">
                <select name="resultado">
                    <option value="">Resultado (todos)</option>
                    @foreach(['aprovado', 'reprovado', 'condicional'] as $r)
                        <option value="{{ $r }}" {{ request('resultado') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
                <input type="date" name="from" value="{{ request('from') }}" />
                <input type="date" name="to" value="{{ request('to') }}" />
                <button type="submit" class="btn">Filtrar</button>
                @if(request()->hasAny(['resultado', 'from', 'to']))
                    <a href="{{ route('calibracoes.index') }}" class="btn btn-secondary">Limpar</a>
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
                        <td>{{ $calibracao->data_envio ? \Carbon\Carbon::parse($calibracao->data_envio)->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $calibracao->data_retorno ? \Carbon\Carbon::parse($calibracao->data_retorno)->format('d/m/Y') : '-' }}
                        </td>
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

        <div class="pagination-wrapper">
            {{ $calibracoes->links() }}
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Lotes de Envio - Sistema de Calibração')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>📦 Lotes de Envio</h2>
            <div>
                <a href="{{ route('lotes.export', request()->all()) }}" class="btn btn-success">📊 Exportar Excel</a>
                <a href="/lotes/create" class="btn btn-primary">+ Novo Lote</a>
            </div>
        </div>
        <form method="GET" action="{{ route('lotes.index') }}" class="filter-form">
            <div class="form-row">
                <select name="status">
                    <option value="">Status (todos)</option>
                    @foreach(['preparacao', 'enviado', 'em_calibracao', 'concluido', 'cancelado'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', ucfirst($s)) }}
                        </option>
                    @endforeach
                </select>
                <select name="laboratorio_id">
                    <option value="">Laboratório (todos)</option>
                    @foreach(($laboratorios ?? []) as $lab)
                        <option value="{{ $lab->id }}" {{ (string) request('laboratorio_id') === (string) $lab->id ? 'selected' : '' }}>{{ $lab->nome }}</option>
                    @endforeach
                </select>
                <input type="date" name="from" value="{{ request('from') }}" />
                <input type="date" name="to" value="{{ request('to') }}" />
                <button type="submit" class="btn">Filtrar</button>
                @if(request()->hasAny(['status', 'laboratorio_id', 'from', 'to']))
                    <a href="{{ route('lotes.index') }}" class="btn btn-secondary">Limpar</a>
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
                    <th>Número do Lote</th>
                    <th>Laboratório</th>
                    <th>Data Envio</th>
                    <th>Previsão Retorno</th>
                    <th>Qtd Equipamentos</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lotes ?? [] as $lote)
                    <tr>
                        <td>{{ $lote->id }}</td>
                        <td><strong>{{ $lote->numero_lote }}</strong></td>
                        <td>{{ $lote->laboratorio->nome ?? 'N/A' }}</td>
                        <td>{{ $lote->data_envio ? \Carbon\Carbon::parse($lote->data_envio)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $lote->previsao_retorno ? \Carbon\Carbon::parse($lote->previsao_retorno)->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $lote->itens->count() ?? 0 }}</td>
                        <td>
                            @if($lote->status === 'enviado')
                                <span class="badge badge-info">Enviado</span>
                            @elseif($lote->status === 'retornado')
                                <span class="badge badge-success">Retornado</span>
                            @else
                                <span class="badge badge-warning">Pendente</span>
                            @endif
                        </td>
                        <td>
                            <a href="/lotes/{{ $lote->id }}" class="btn btn-sm btn-primary">Ver</a>
                            <a href="/lotes/{{ $lote->id }}/edit" class="btn btn-sm btn-success">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum lote criado. <a href="/lotes/create">Crie o primeiro lote</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $lotes->links() }}
        </div>
    </div>
@endsection
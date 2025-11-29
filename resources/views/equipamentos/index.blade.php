@extends('layouts.app')

@section('title', 'Equipamentos - Sistema de Calibração')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>📋 Equipamentos</h2>
            <div>
                <a href="{{ route('equipamentos.export', request()->all()) }}" class="btn btn-success">📊 Exportar Excel</a>
                <a href="{{ route('equipamentos.create') }}" class="btn btn-primary">+ Novo Equipamento</a>
            </div>
        </div>

        <form method="GET" action="{{ route('equipamentos.index') }}" class="filter-form">
            <div class="form-row">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Buscar (código, tipo, fabricante, modelo)" />
                <select name="criticidade">
                    <option value="">Criticidade (todas)</option>
                    @foreach(['baixa', 'media', 'alta', 'critica'] as $c)
                        <option value="{{ $c }}" {{ request('criticidade') === $c ? 'selected' : '' }}>{{ ucfirst($c) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn">Filtrar</button>
                @if(request()->hasAny(['q', 'criticidade']))
                    <a href="{{ route('equipamentos.index') }}" class="btn btn-secondary">Limpar</a>
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
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Fabricante</th>
                    <th>Modelo</th>
                    <th>Criticidade</th>
                    <th>Próxima Calibração</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipamentos ?? [] as $equipamento)
                    <tr>
                        <td><strong>{{ $equipamento->codigo_interno }}</strong></td>
                        <td>{{ $equipamento->tipo }}</td>
                        <td>{{ $equipamento->fabricante ?? '-' }}</td>
                        <td>{{ $equipamento->modelo ?? '-' }}</td>
                        <td>
                            @if($equipamento->criticidade === 'critica')
                                <span class="badge badge-danger">Crítica</span>
                            @elseif($equipamento->criticidade === 'alta')
                                <span class="badge badge-warning">Alta</span>
                            @elseif($equipamento->criticidade === 'media')
                                <span class="badge badge-info">Média</span>
                            @else
                                <span class="badge badge-secondary">Baixa</span>
                            @endif
                        </td>
                        <td>
                            @if($equipamento->data_proxima_calibracao)
                                {{ \Carbon\Carbon::parse($equipamento->data_proxima_calibracao)->format('d/m/Y') }}
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($equipamento->status_calibracao === 'vencida')
                                <span class="badge badge-danger">Vencida</span>
                            @elseif($equipamento->status_calibracao === 'critica')
                                <span class="badge badge-danger">Crítica (≤7d)</span>
                            @elseif($equipamento->status_calibracao === 'proxima')
                                <span class="badge badge-warning">Próxima (≤30d)</span>
                            @elseif($equipamento->status_calibracao === 'em_dia')
                                <span class="badge badge-success">Em dia</span>
                            @else
                                <span class="badge badge-secondary">Sem calibração</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('equipamentos.show', $equipamento) }}" class="btn btn-sm btn-primary">Ver</a>
                            <a href="{{ route('equipamentos.edit', $equipamento) }}" class="btn btn-sm btn-success">Editar</a>
                            <form action="{{ route('equipamentos.destroy', $equipamento) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Tem certeza que deseja excluir este equipamento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
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

        <div class="pagination-wrapper">
            {{ $equipamentos->links() }}
        </div>
    </div>
@endsection
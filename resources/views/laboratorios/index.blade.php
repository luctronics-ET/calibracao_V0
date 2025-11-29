@extends('layouts.app')

@section('title', 'Laboratórios - Sistema de Calibração')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>🏢 Laboratórios</h2>
            <a href="/laboratorios/create" class="btn btn-primary">+ Novo Laboratório</a>
        </div>

        <form method="GET" action="{{ route('laboratorios.index') }}" class="filter-form">
            <div class="form-row">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar por nome ou CNPJ" />
                <button type="submit" class="btn">Filtrar</button>
                @if(request()->has('q'))
                    <a href="{{ route('laboratorios.index') }}" class="btn btn-secondary">Limpar</a>
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
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laboratorios ?? [] as $laboratorio)
                    <tr>
                        <td>{{ $laboratorio->id }}</td>
                        <td><strong>{{ $laboratorio->nome }}</strong></td>
                        <td>{{ $laboratorio->cnpj }}</td>
                        <td>{{ $laboratorio->telefone }}</td>
                        <td>{{ $laboratorio->email }}</td>
                        <td>
                            @if($laboratorio->ativo)
                                <span class="badge badge-success">Ativo</span>
                            @else
                                <span class="badge badge-danger">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <a href="/laboratorios/{{ $laboratorio->id }}" class="btn btn-sm btn-primary">Ver</a>
                            <a href="/laboratorios/{{ $laboratorio->id }}/edit" class="btn btn-sm btn-success">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum laboratório cadastrado. <a href="/laboratorios/create">Cadastre o primeiro</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $laboratorios->links() }}
        </div>
    </div>
@endsection
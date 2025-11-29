@extends('layouts.app')

@section('title', 'Detalhes do Log')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Detalhes do Log #{{ $log->id }}</h1>
                <a href="{{ route('logs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                    style="text-decoration: none;">
                    Voltar
                </a>
            </div>

            <!-- Informações Principais -->
            <div class="bg-white shadow-md rounded px-8 py-6 mb-6" style="box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2" style="border-color: #e5e7eb;">
                    Informações Gerais</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"
                    style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Data/Hora</p>
                        <p class="text-lg">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Tabela</p>
                        <p class="text-lg">{{ ucfirst($log->tabela) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Ação</p>
                        <p class="text-lg">
                            @if($log->acao === 'create')
                                <span class="badge badge-success">Criar</span>
                            @elseif($log->acao === 'update')
                                <span class="badge badge-warning">Atualizar</span>
                            @elseif($log->acao === 'delete')
                                <span class="badge badge-danger">Excluir</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">ID do Registro</p>
                        <p class="text-lg">#{{ $log->registro_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Usuário</p>
                        <p class="text-lg">{{ $log->usuario->name ?? 'Sistema' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold">Endereço IP</p>
                        <p class="text-lg"><code>{{ $log->ip }}</code></p>
                    </div>
                    <div style="grid-column: span 2;">
                        <p class="text-sm text-gray-600 font-semibold">User Agent</p>
                        <p class="text-sm" style="word-break: break-all; color: #6b7280;">{{ $log->user_agent ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Dados Modificados -->
            @if($log->dados)
                @php
                    $dados = json_decode($log->dados, true);
                @endphp

                <div class="bg-white shadow-md rounded px-8 py-6" style="box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2" style="border-color: #e5e7eb;">Dados
                        Modificados</h2>

                    @if(isset($dados['before']) && $log->acao === 'update')
                        <h3 class="text-lg font-semibold text-gray-600 mt-4 mb-2">Antes:</h3>
                        <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; overflow-x: auto;">
                            <pre
                                style="margin: 0; white-space: pre-wrap; word-wrap: break-word; font-size: 12px;">{{ json_encode($dados['before'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif

                    @if(isset($dados['after']))
                        <h3 class="text-lg font-semibold text-gray-600 mt-4 mb-2">Depois:</h3>
                        <div style="background: #f0fdf4; padding: 1rem; border-radius: 6px; overflow-x: auto;">
                            <pre
                                style="margin: 0; white-space: pre-wrap; word-wrap: break-word; font-size: 12px;">{{ json_encode($dados['after'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif

                    @if(isset($dados['before']) && $log->acao === 'delete')
                        <h3 class="text-lg font-semibold text-gray-600 mt-4 mb-2">Dados Removidos:</h3>
                        <div style="background: #fef2f2; padding: 1rem; border-radius: 6px; overflow-x: auto;">
                            <pre
                                style="margin: 0; white-space: pre-wrap; word-wrap: break-word; font-size: 12px;">{{ json_encode($dados['before'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
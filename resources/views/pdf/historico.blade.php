<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Histórico de Calibrações - {{ $equipamento->nome }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 22px;
            color: #0066cc;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 14px;
            color: #666;
            font-weight: normal;
        }

        .info-box {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            color: #0066cc;
        }

        .info-value {
            display: table-cell;
            width: 70%;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0066cc;
            margin: 20px 0 15px 0;
            border-bottom: 2px solid #0066cc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table th {
            background-color: #0066cc;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
        }

        table td {
            border: 1px solid #ddd;
            padding: 6px 5px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
        }

        .badge-aprovado {
            background-color: #28a745;
            color: white;
        }

        .badge-reprovado {
            background-color: #dc3545;
            color: white;
        }

        .badge-pendente {
            background-color: #ffc107;
            color: #333;
        }

        .summary-box {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 12px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }

        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #0066cc;
        }

        .summary-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>HISTÓRICO DE CALIBRAÇÕES</h1>
        <h2>Registro Completo de Manutenções e Calibrações</h2>
    </div>

    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Equipamento:</span>
            <span class="info-value"><strong>{{ $equipamento->nome }}</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tipo:</span>
            <span class="info-value">{{ ucfirst($equipamento->tipo) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Número de Série:</span>
            <span class="info-value">{{ $equipamento->numero_serie }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Patrimônio:</span>
            <span class="info-value">{{ $equipamento->patrimonio ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Criticidade:</span>
            <span class="info-value">{{ ucfirst($equipamento->criticidade) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Localização:</span>
            <span class="info-value">{{ $equipamento->localizacao }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Ciclo de Calibração:</span>
            <span class="info-value">{{ $equipamento->ciclo_meses }} meses</span>
        </div>
    </div>

    @php
        $totalCalibracoes = $equipamento->calibracoes->count();
        $aprovadas = $equipamento->calibracoes->where('status', 'aprovado')->count();
        $reprovadas = $equipamento->calibracoes->where('status', 'reprovado')->count();
        $pendentes = $equipamento->calibracoes->where('status', 'pendente')->count();

        $ultimaCalibracao = $equipamento->calibracoes->sortByDesc('data_calibracao')->first();
        $proximaCalibracao = null;

        if ($ultimaCalibracao && $ultimaCalibracao->data_validade) {
            $proximaCalibracao = \Carbon\Carbon::parse($ultimaCalibracao->data_validade);
            $diasRestantes = \Carbon\Carbon::now()->diffInDays($proximaCalibracao, false);
        }
    @endphp

    @if($ultimaCalibracao)
        @if(isset($diasRestantes))
            @if($diasRestantes < 0)
                <div class="alert alert-danger">
                    <strong>⚠️ CALIBRAÇÃO VENCIDA!</strong> A calibração venceu há {{ abs($diasRestantes) }} dias. Ação imediata
                    necessária.
                </div>
            @elseif($diasRestantes <= 30)
                <div class="alert alert-warning">
                    <strong>⚠️ Atenção:</strong> Calibração vence em {{ $diasRestantes }} dias
                    ({{ $proximaCalibracao->format('d/m/Y') }}).
                </div>
            @else
                <div class="alert alert-success">
                    <strong>✓ Calibração em dia.</strong> Próxima calibração em {{ $proximaCalibracao->format('d/m/Y') }}
                    ({{ $diasRestantes }} dias).
                </div>
            @endif
        @endif
    @endif

    <div class="summary-box">
        <div class="summary-item">
            <div class="summary-value">{{ $totalCalibracoes }}</div>
            <div class="summary-label">Total de Calibrações</div>
        </div>
        <div class="summary-item">
            <div class="summary-value" style="color: #28a745;">{{ $aprovadas }}</div>
            <div class="summary-label">Aprovadas</div>
        </div>
        <div class="summary-item">
            <div class="summary-value" style="color: #dc3545;">{{ $reprovadas }}</div>
            <div class="summary-label">Reprovadas</div>
        </div>
        <div class="summary-item">
            <div class="summary-value" style="color: #ffc107;">{{ $pendentes }}</div>
            <div class="summary-label">Pendentes</div>
        </div>
    </div>

    <h3 class="section-title">Histórico de Calibrações</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Cert. Nº</th>
                <th style="width: 12%;">Data</th>
                <th style="width: 12%;">Validade</th>
                <th style="width: 25%;">Laboratório</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Custo (R$)</th>
                <th style="width: 23%;">Observações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipamento->calibracoes->sortByDesc('data_calibracao') as $calibracao)
                <tr>
                    <td style="text-align: center;">{{ str_pad($calibracao->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($calibracao->data_validade)->format('d/m/Y') }}</td>
                    <td>{{ $calibracao->laboratorio->nome ?? 'N/A' }}</td>
                    <td>
                        <span class="badge badge-{{ $calibracao->status }}">
                            {{ strtoupper($calibracao->status) }}
                        </span>
                    </td>
                    <td style="text-align: right;">{{ number_format($calibracao->custo ?? 0, 2, ',', '.') }}</td>
                    <td style="font-size: 10px;">{{ \Illuminate\Support\Str::limit($calibracao->observacoes ?? '-', 50) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                        Nenhuma calibração registrada para este equipamento
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($totalCalibracoes > 0)
        <h3 class="section-title">Estatísticas</h3>
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Primeira Calibração:</span>
                <span class="info-value">
                    {{ $equipamento->calibracoes->sortBy('data_calibracao')->first()
            ? \Carbon\Carbon::parse($equipamento->calibracoes->sortBy('data_calibracao')->first()->data_calibracao)->format('d/m/Y')
            : 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Última Calibração:</span>
                <span class="info-value">
                    {{ $ultimaCalibracao
            ? \Carbon\Carbon::parse($ultimaCalibracao->data_calibracao)->format('d/m/Y')
            : 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Custo Total em Calibrações:</span>
                <span class="info-value">R$
                    {{ number_format($equipamento->calibracoes->sum('custo') ?? 0, 2, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Custo Médio por Calibração:</span>
                <span class="info-value">R$
                    {{ number_format($equipamento->calibracoes->avg('custo') ?? 0, 2, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Taxa de Aprovação:</span>
                <span
                    class="info-value">{{ $totalCalibracoes > 0 ? number_format(($aprovadas / $totalCalibracoes) * 100, 1) : 0 }}%</span>
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Este documento apresenta o histórico completo de calibrações do equipamento {{ $equipamento->nome }}.</p>
        <p>Documento gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        <p>Equipamento: {{ $equipamento->numero_serie }} | Patrimônio: {{ $equipamento->patrimonio ?? 'N/A' }}</p>
    </div>
</body>

</html>
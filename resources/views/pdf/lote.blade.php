<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Lista de Lote de Envio - {{ $lote->numero_lote }}</title>
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
            width: 35%;
            color: #0066cc;
        }

        .info-value {
            display: table-cell;
            width: 65%;
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

        .badge-preparacao {
            background-color: #ffc107;
            color: #333;
        }

        .badge-enviado {
            background-color: #17a2b8;
            color: white;
        }

        .badge-em_calibracao {
            background-color: #007bff;
            color: white;
        }

        .badge-retornado {
            background-color: #28a745;
            color: white;
        }

        .badge-cancelado {
            background-color: #dc3545;
            color: white;
        }

        .summary-box {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #0066cc;
        }

        .summary-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LISTA DE LOTE DE ENVIO</h1>
        <h2>Controle de Equipamentos para Calibração</h2>
    </div>

    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Número do Lote:</span>
            <span class="info-value"><strong>{{ $lote->numero_lote }}</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">Data de Envio:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($lote->data_envio)->format('d/m/Y') }}</span>
        </div>
        @if($lote->data_retorno)
            <div class="info-row">
                <span class="info-label">Data de Retorno:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($lote->data_retorno)->format('d/m/Y') }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">
                <span class="badge badge-{{ $lote->status }}">
                    {{ strtoupper(str_replace('_', ' ', $lote->status)) }}
                </span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Responsável:</span>
            <span class="info-value">{{ $lote->responsavel ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <div class="summary-value">{{ $lote->equipamentos->count() }}</div>
            <div class="summary-label">Total de Equipamentos</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">{{ number_format($lote->valor_total ?? 0, 2, ',', '.') }}</div>
            <div class="summary-label">Valor Total (R$)</div>
        </div>
        <div class="summary-item">
            <div class="summary-value">
                @if($lote->data_envio && $lote->data_retorno)
                    {{ \Carbon\Carbon::parse($lote->data_envio)->diffInDays(\Carbon\Carbon::parse($lote->data_retorno)) }}
                @else
                    -
                @endif
            </div>
            <div class="summary-label">Dias de Processamento</div>
        </div>
    </div>

    <h3 class="section-title">Equipamentos do Lote</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Nome</th>
                <th style="width: 15%;">Tipo</th>
                <th style="width: 15%;">Nº Série</th>
                <th style="width: 15%;">Patrimônio</th>
                <th style="width: 12%;">Criticidade</th>
                <th style="width: 13%;">Localização</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lote->equipamentos as $index => $equipamento)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $equipamento->nome }}</td>
                    <td>{{ ucfirst($equipamento->tipo) }}</td>
                    <td>{{ $equipamento->numero_serie }}</td>
                    <td>{{ $equipamento->patrimonio ?? '-' }}</td>
                    <td>{{ ucfirst($equipamento->criticidade) }}</td>
                    <td>{{ $equipamento->localizacao }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                        Nenhum equipamento vinculado a este lote
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($lote->observacoes)
        <h3 class="section-title">Observações</h3>
        <div class="info-box">
            <p>{{ $lote->observacoes }}</p>
        </div>
    @endif

    <div style="margin-top: 40px; page-break-inside: avoid;">
        <h3 class="section-title">Assinaturas</h3>
        <table style="border: none;">
            <tr>
                <td style="border: none; width: 50%; padding: 40px 20px 10px 0; text-align: center;">
                    <div style="border-top: 1px solid #333; padding-top: 5px;">
                        <strong>Responsável pelo Envio</strong><br>
                        Data: ___/___/______
                    </div>
                </td>
                <td style="border: none; width: 50%; padding: 40px 0 10px 20px; text-align: center;">
                    <div style="border-top: 1px solid #333; padding-top: 5px;">
                        <strong>Responsável pelo Recebimento</strong><br>
                        Data: ___/___/______
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Este documento comprova o envio dos equipamentos listados para o processo de calibração.</p>
        <p>Documento gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        <p>Lote nº {{ $lote->numero_lote }}</p>
    </div>
</body>

</html>
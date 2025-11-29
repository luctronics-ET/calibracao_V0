<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificado de Calibração - {{ $calibracao->equipamento->nome }}</title>
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
            padding: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #0066cc;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 16px;
            color: #666;
            font-weight: normal;
        }

        .info-box {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 40%;
            color: #0066cc;
        }

        .info-value {
            display: table-cell;
            width: 60%;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0066cc;
            margin: 25px 0 15px 0;
            border-bottom: 2px solid #0066cc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th {
            background-color: #0066cc;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .signature-box {
            margin-top: 60px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 300px;
            margin: 0 auto 10px auto;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 11px;
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

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(0, 102, 204, 0.05);
            z-index: -1;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="watermark">CERTIFICADO</div>

    <div class="header">
        <h1>CERTIFICADO DE CALIBRAÇÃO</h1>
        <h2>{{ $calibracao->laboratorio->nome }}</h2>
        <p style="margin-top: 10px; color: #666;">
            {{ $calibracao->laboratorio->endereco }} |
            CNPJ: {{ $calibracao->laboratorio->cnpj }} |
            Tel: {{ $calibracao->laboratorio->telefone }}
        </p>
    </div>

    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Número do Certificado:</span>
            <span class="info-value">{{ str_pad($calibracao->id, 8, '0', STR_PAD_LEFT) }}/{{ date('Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Data de Emissão:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($calibracao->data_calibracao)->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Validade:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($calibracao->data_validade)->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">
                <span class="badge badge-{{ $calibracao->status }}">
                    {{ strtoupper($calibracao->status) }}
                </span>
            </span>
        </div>
    </div>

    <h3 class="section-title">Dados do Equipamento</h3>
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Nome:</span>
            <span class="info-value">{{ $calibracao->equipamento->nome }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tipo:</span>
            <span class="info-value">{{ ucfirst($calibracao->equipamento->tipo) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Número de Série:</span>
            <span class="info-value">{{ $calibracao->equipamento->numero_serie }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Patrimônio:</span>
            <span class="info-value">{{ $calibracao->equipamento->patrimonio ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Criticidade:</span>
            <span class="info-value">{{ ucfirst($calibracao->equipamento->criticidade) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Localização:</span>
            <span class="info-value">{{ $calibracao->equipamento->localizacao }}</span>
        </div>
    </div>

    @if($calibracao->parametros && $calibracao->parametros->count() > 0)
        <h3 class="section-title">Parâmetros Metrológicos</h3>
        <table>
            <thead>
                <tr>
                    <th>Parâmetro</th>
                    <th>Valor Medido</th>
                    <th>Valor de Referência</th>
                    <th>Incerteza</th>
                    <th>Unidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calibracao->parametros as $parametro)
                    <tr>
                        <td>{{ $parametro->parametro }}</td>
                        <td>{{ $parametro->valor_medido }}</td>
                        <td>{{ $parametro->valor_referencia }}</td>
                        <td>{{ $parametro->incerteza }}</td>
                        <td>{{ $parametro->unidade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($calibracao->observacoes)
        <h3 class="section-title">Observações</h3>
        <div class="info-box">
            <p>{{ $calibracao->observacoes }}</p>
        </div>
    @endif

    <h3 class="section-title">Informações do Laboratório</h3>
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Laboratório:</span>
            <span class="info-value">{{ $calibracao->laboratorio->nome }}</span>
        </div>
        @if($calibracao->laboratorio->acreditacao)
            <div class="info-row">
                <span class="info-label">Acreditação:</span>
                <span class="info-value">{{ $calibracao->laboratorio->acreditacao }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $calibracao->laboratorio->email }}</span>
        </div>
    </div>

    <div class="signature-box">
        <div class="signature-line"></div>
        <p><strong>Responsável Técnico</strong></p>
        <p>{{ $calibracao->laboratorio->nome }}</p>
    </div>

    <div class="footer">
        <p>Este certificado é válido somente com assinatura e carimbo do laboratório emissor.</p>
        <p>Certificado gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        <p>Documento nº {{ str_pad($calibracao->id, 8, '0', STR_PAD_LEFT) }}/{{ date('Y') }}</p>
    </div>
</body>

</html>
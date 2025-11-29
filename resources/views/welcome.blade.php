@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Calibração')

@section('content')
<div class="grid">
    <div class="stat-card">
        <h3>Total de Equipamentos</h3>
        <div class="value">{{ $totalEquipamentos ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Calibrações Ativas</h3>
        <div class="value">{{ $calibracoesAtivas ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Lotes em Andamento</h3>
        <div class="value">{{ $lotesAndamento ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Laboratórios</h3>
        <div class="value">{{ $totalLaboratorios ?? 0 }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>📊 Visão Geral do Sistema</h2>
    </div>
    
    <div style="text-align: center; padding: 3rem;">
        <h3 style="color: #667eea; margin-bottom: 1rem;">Sistema de Calibração Online</h3>
        <p style="color: #6b7280; margin-bottom: 2rem;">Laravel {{ app()->version() }} + Vue 3 + SQLite</p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="/equipamentos" class="btn btn-primary">📋 Gerenciar Equipamentos</a>
            <a href="/calibracoes" class="btn btn-success">🔬 Calibrações</a>
            <a href="/lotes" class="btn btn-primary">📦 Lotes de Envio</a>
        </div>
    </div>
</div>
@endsection
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 600px;
        }
        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 40px;
        }
        .badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }
        .info {
            background: #f3f4f6;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-item:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 500; }
        .info-value { color: #111827; font-weight: 600; }
        .links { margin-top: 30px; }
        .link {
            display: inline-block;
            margin: 10px;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .link:hover { background: #5568d3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="badge">✅ Sistema Online</div>
        <h1>🔧 Sistema de Calibração</h1>
        <p class="subtitle">Laravel + Vue 3 + SQLite</p>
        
        <div class="info">
            <div class="info-item">
                <span class="info-label">Framework</span>
                <span class="info-value">Laravel {{ app()->version() }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">PHP</span>
                <span class="info-value">{{ PHP_VERSION }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Banco de Dados</span>
                <span class="info-value">SQLite</span>
            </div>
        </div>

        <div class="links">
            <a href="/api/equipamentos" class="link">📋 API Equipamentos</a>
        </div>
    </div>
</body>
</html>

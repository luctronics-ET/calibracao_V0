#!/bin/bash

echo "🐳 Iniciando ambiente Docker para Sistema de Calibração..."

# Verificar se Docker está rodando
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker não está rodando. Inicie o Docker Desktop ou serviço Docker."
    exit 1
fi

# Parar containers anteriores
echo "🛑 Parando containers anteriores..."
docker compose down

# Construir imagens
echo "🔨 Construindo imagens Docker..."
docker compose build --no-cache

# Iniciar containers
echo "🚀 Iniciando containers..."
docker compose up -d

# Aguardar containers iniciarem
echo "⏳ Aguardando containers iniciarem..."
sleep 5

# Verificar se containers estão rodando
echo "✅ Verificando status dos containers..."
docker compose ps

# Gerar chave da aplicação se necessário
echo "🔑 Configurando aplicação Laravel..."
docker compose exec -T app php artisan key:generate

# Executar migrations
echo "📊 Executando migrations..."
docker compose exec -T app php artisan migrate --force

# Otimizar aplicação
echo "⚡ Otimizando aplicação..."
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

echo ""
echo "✅ Ambiente Docker configurado com sucesso!"
echo ""
echo "📍 URLs disponíveis:"
echo "   - Aplicação Laravel: http://localhost:8080"
echo "   - Vite Dev Server: http://localhost:5173"
echo ""
echo "📋 Comandos úteis:"
echo "   - Ver logs: docker compose logs -f"
echo "   - Parar: docker compose down"
echo "   - Restart: docker compose restart"
echo "   - Entrar no container: docker compose exec app bash"
echo ""

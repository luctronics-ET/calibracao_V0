#!/bin/bash

echo "🚀 Configurando ambiente Laravel + Vue..."

# Instalar extensões PHP necessárias
echo "📦 Instalando extensões PHP..."
sudo apt-get update
sudo apt-get install -y \
    php8.3-xml \
    php8.3-dom \
    php8.3-curl \
    php8.3-mbstring \
    php8.3-sqlite3 \
    php8.3-zip \
    sqlite3

# Instalar dependências do Composer
echo "📦 Instalando dependências PHP (Composer)..."
if [ -f "composer.json" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Instalar dependências do NPM
echo "📦 Instalando dependências JavaScript (NPM)..."
if [ -f "package.json" ]; then
    npm install
fi

# Configurar permissões
echo "🔐 Configurando permissões..."
chmod -R 775 storage bootstrap/cache
chown -R vscode:vscode storage bootstrap/cache

# Verificar se o arquivo .env existe
if [ ! -f ".env" ]; then
    echo "📝 Criando arquivo .env..."
    cp .env.example .env
    php artisan key:generate
fi

# Criar banco de dados SQLite se não existir
if [ ! -f "database/database.sqlite" ]; then
    echo "🗄️ Criando banco de dados SQLite..."
    touch database/database.sqlite
fi

# Executar migrations
echo "🗄️ Executando migrations..."
php artisan migrate --force

# Limpar cache
echo "🧹 Limpando cache..."
php artisan config:clear
php artisan cache:clear

echo "✅ Ambiente configurado com sucesso!"
echo "🌐 Servidores disponíveis:"
echo "   - Laravel: php artisan serve"
echo "   - Vite: npm run dev"

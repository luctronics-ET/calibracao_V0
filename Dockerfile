FROM php:8.3-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    sqlite3 \
    libsqlite3-dev

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd

# Obter Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www

# Copiar arquivos existentes
COPY . /var/www

# Configurar permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Instalar dependências do Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Instalar dependências do NPM
RUN npm install

# Compilar assets
RUN npm run build

# Expor porta 9000
EXPOSE 9000

CMD ["php-fpm"]

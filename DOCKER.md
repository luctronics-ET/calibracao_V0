# Docker para Sistema de Calibração

## 🚀 Início Rápido

Execute o script de inicialização:

```bash
./docker-start.sh
```

Ou manualmente:

```bash
# Construir e iniciar containers
docker-compose up -d --build

# Ver logs
docker-compose logs -f

# Parar containers
docker-compose down
```

## 📦 Serviços Disponíveis

- **app**: PHP 8.3-FPM com Laravel
- **nginx**: Servidor web (porta 8080)
- **vite**: Dev server para hot reload (porta 5173)

## 🌐 URLs

- Aplicação: http://localhost:8080
- Vite HMR: http://localhost:5173

## 🛠️ Comandos Úteis

```bash
# Acessar container da aplicação
docker-compose exec app bash

# Executar comandos artisan
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

# Instalar dependências
docker-compose exec app composer install
docker-compose exec vite npm install

# Ver logs específicos
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f vite

# Reiniciar serviços
docker-compose restart
docker-compose restart app
```

## 🔧 Configuração

A configuração Docker inclui:

- **Dockerfile**: Imagem PHP 8.3 com extensões necessárias
- **docker-compose.yml**: Orquestração de serviços
- **docker/nginx/nginx.conf**: Configuração Nginx com proxy para Vite
- **docker/php/php.ini**: Configurações PHP customizadas
- **.env.docker**: Variáveis de ambiente para Docker

## 📝 Notas

- O banco SQLite é montado como volume
- Storage e cache são persistentes
- Hot reload funciona via proxy Nginx → Vite

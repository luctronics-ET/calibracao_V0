# 📦 Guia de Instalação - Sistema de Gestão de Calibração

## Pré-requisitos

### Obrigatórios

- **Docker** >= 20.10
- **Docker Compose** >= 2.0
- **Git** >= 2.30

### Recomendados

- Sistema Operacional: Ubuntu 20.04+ / Debian 11+ / macOS 12+ / Windows 10+ (com WSL2)
- RAM: 2GB mínimo, 4GB recomendado
- Disco: 5GB de espaço livre

## 🚀 Instalação Rápida (Desenvolvimento)

### 1. Clonar o Repositório

```bash
git clone https://github.com/luctronics-ET/calibracao_V0.git
cd calibracao_V0
```

### 2. Configurar Variáveis de Ambiente

```bash
# Copiar arquivo de exemplo
cp .env.example .env

# Editar conforme necessário
nano .env
```

### 3. Iniciar Containers Docker

```bash
# Build e start dos containers
docker compose up -d

# Verificar se os containers estão rodando
docker compose ps
```

### 4. Instalar Dependências PHP

```bash
# Entrar no container
docker compose exec app bash

# Instalar dependências do Composer
composer install

# Gerar chave da aplicação
php artisan key:generate

# Sair do container
exit
```

### 5. Configurar Banco de Dados

```bash
# Criar arquivo do banco SQLite
docker compose exec app touch database/database.sqlite

# Executar migrações
docker compose exec app php artisan migrate

# (Opcional) Popular com dados de exemplo
docker compose exec app php artisan db:seed
```

### 6. Acessar a Aplicação

Abra o navegador em: **http://localhost:8080**

**Credenciais padrão:**

- **Admin:** admin@calibracao.com / admin123
- **Técnico:** tecnico@calibracao.com / tecnico123
- **Visualizador:** visualizador@calibracao.com / visualizador123

## 🏭 Instalação em Produção

### 1. Preparar Servidor

```bash
# Atualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Instalar Docker Compose
sudo apt install docker-compose-plugin -y

# Adicionar usuário ao grupo docker
sudo usermod -aG docker $USER
```

### 2. Clonar e Configurar

```bash
# Clonar repositório
git clone https://github.com/luctronics-ET/calibracao_V0.git
cd calibracao_V0

# Criar .env de produção
cp .env.example .env
nano .env
```

**Variáveis importantes para produção:**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

# Configurar banco de dados
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=calibracao_prod
DB_USERNAME=usuario_seguro
DB_PASSWORD=senha_forte_aqui

# Configurar email
MAIL_MAILER=smtp
MAIL_HOST=smtp.seuservidor.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@dominio.com
MAIL_PASSWORD=sua_senha_email
MAIL_ENCRYPTION=tls
```

### 3. Usar Docker Compose de Produção

```bash
# Copiar configuração de produção
cp docker-compose.production.yml docker-compose.yml

# Editar configurações de Nginx (opcional)
nano docker/nginx/prod.conf

# Iniciar containers
docker compose up -d
```

### 4. Configurar SSL/HTTPS (Recomendado)

```bash
# Instalar Certbot
sudo apt install certbot -y

# Gerar certificado SSL
sudo certbot certonly --standalone -d seu-dominio.com

# Copiar certificados para pasta ssl/
sudo cp /etc/letsencrypt/live/seu-dominio.com/fullchain.pem ssl/
sudo cp /etc/letsencrypt/live/seu-dominio.com/privkey.pem ssl/
```

### 5. Deploy Inicial

```bash
# Tornar script executável
chmod +x deploy.sh

# Executar deploy completo
./deploy.sh --full
```

### 6. Configurar Cron para Notificações

```bash
# Editar crontab
crontab -e

# Adicionar linha:
0 8 * * * cd /caminho/para/calibracao_V0 && docker compose exec -T app php artisan calibracao:verificar-vencimento >> /var/log/calibracao-cron.log 2>&1
```

## 🔧 Comandos Úteis

### Docker

```bash
# Ver logs dos containers
docker compose logs -f

# Ver logs de um container específico
docker compose logs -f app

# Reiniciar containers
docker compose restart

# Parar containers
docker compose down

# Rebuild completo
docker compose down
docker compose build --no-cache
docker compose up -d
```

### Laravel/Artisan

```bash
# Limpar cache
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear

# Otimizar para produção
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# Executar migrações
docker compose exec app php artisan migrate

# Reverter última migração
docker compose exec app php artisan migrate:rollback

# Executar seeders
docker compose exec app php artisan db:seed

# Verificar calibrações vencendo
docker compose exec app php artisan calibracao:verificar-vencimento

# Ver agenda de tasks
docker compose exec app php artisan schedule:list
```

### Testes

```bash
# Executar todos os testes
docker compose exec app vendor/bin/phpunit

# Executar testes com output detalhado
docker compose exec app vendor/bin/phpunit --testdox

# Executar teste específico
docker compose exec app vendor/bin/phpunit tests/Feature/EquipamentoTest.php

# Executar com cobertura (requer Xdebug)
docker compose exec app vendor/bin/phpunit --coverage-html coverage
```

### Backup

```bash
# Backup do banco de dados
docker compose exec app php artisan backup:run

# Backup manual do SQLite
cp database/database.sqlite backups/database_$(date +%Y%m%d_%H%M%S).sqlite

# Backup de arquivos uploadados
tar -czf backups/storage_$(date +%Y%m%d_%H%M%S).tar.gz storage/app/public
```

## 🔒 Segurança em Produção

### Checklist de Segurança

- [ ] `APP_DEBUG=false` no .env
- [ ] `APP_ENV=production` no .env
- [ ] Senha forte no `APP_KEY`
- [ ] SSL/HTTPS configurado
- [ ] Firewall configurado (portas 80, 443)
- [ ] Alterar credenciais padrão
- [ ] Configurar backup automático
- [ ] Limitar acesso SSH
- [ ] Configurar rate limiting
- [ ] Revisar permissões de arquivos

### Permissões de Arquivos

```bash
# Ajustar permissões
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## 🐛 Troubleshooting

### Erro: "Permission denied" em storage/

```bash
docker compose exec app chmod -R 775 storage bootstrap/cache
```

### Erro: "Database file not found"

```bash
docker compose exec app touch database/database.sqlite
docker compose exec app php artisan migrate
```

### Erro: "500 Internal Server Error"

```bash
# Ver logs do Laravel
docker compose logs app

# Verificar logs do Nginx
docker compose logs nginx

# Habilitar debug temporariamente
APP_DEBUG=true no .env
```

### Container não inicia

```bash
# Ver logs completos
docker compose logs

# Rebuild containers
docker compose down -v
docker compose build --no-cache
docker compose up -d
```

## 📚 Recursos Adicionais

- [Documentação Laravel 10](https://laravel.com/docs/10.x)
- [Docker Documentation](https://docs.docker.com/)
- [Guia de Deploy](./DEPLOY.md)
- [Relatório Final](./RELATORIO_FINAL.md)

## 🆘 Suporte

Para problemas ou dúvidas:

1. Verificar [TROUBLESHOOTING.md](./docs/TROUBLESHOOTING.md)
2. Consultar logs: `docker compose logs -f`
3. Abrir issue no GitHub

---

**Sistema de Gestão de Calibração v1.0**  
_Desenvolvido com Laravel 10 + Docker_

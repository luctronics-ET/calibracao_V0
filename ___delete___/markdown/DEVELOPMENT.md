# Configuração do Ambiente de Desenvolvimento

Este projeto utiliza Dev Containers para garantir um ambiente consistente.

## 🚀 Início Rápido

### Opção 1: Dev Container (Recomendado)

1. Instale o [Docker Desktop](https://www.docker.com/products/docker-desktop)
2. Instale a extensão [Dev Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) no VS Code
3. Abra o projeto no VS Code
4. Pressione `F1` e selecione: **Dev Containers: Reopen in Container**
5. Aguarde o container ser construído e configurado automaticamente

### Opção 2: Ambiente Local

Se preferir rodar localmente sem Docker:

```bash
# 1. Instalar dependências PHP
composer install

# 2. Instalar dependências JavaScript
npm install

# 3. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 4. Criar banco de dados
touch database/database.sqlite

# 5. Executar migrations
php artisan migrate

# 6. Iniciar servidores
php artisan serve    # Terminal 1 - Laravel (porta 8000)
npm run dev          # Terminal 2 - Vite (porta 5173)
```

## 🛠️ Recursos Disponíveis

### Tasks do VS Code

Pressione `Ctrl+Shift+P` (ou `Cmd+Shift+P` no Mac) e procure por "Tasks: Run Task":

- **Start Laravel Server** - Inicia o servidor Laravel
- **Start Vite Dev Server** - Inicia o Vite para desenvolvimento
- **Start All Servers** - Inicia ambos os servidores
- **Run Migrations** - Executa as migrations do banco
- **Clear Cache** - Limpa o cache do Laravel

### Debug

O projeto já está configurado para debug com Xdebug:

1. Adicione breakpoints no código PHP
2. Pressione `F5` ou vá em Run → Start Debugging
3. Selecione a configuração "Listen for Xdebug"

### Banco de Dados

Para visualizar e editar o banco SQLite:

1. Abra a paleta de comandos (`Ctrl+Shift+P`)
2. Procure por "SQLTools: Connect"
3. Selecione "Calibracao Database"

## 📦 Extensões Instaladas

O ambiente já vem com as seguintes extensões:

- **PHP Intelephense** - IntelliSense para PHP
- **Vue (Volar)** - Suporte para Vue 3
- **Laravel Blade** - Syntax highlighting para Blade
- **Laravel Snippets** - Snippets úteis
- **SQLite** - Visualizador de banco SQLite
- **Prettier** - Formatação de código
- **GitLens** - Git avançado

## 🗂️ Estrutura do Projeto

```
calibracao_V0/
├── app/
│   ├── Http/Controllers/Api/  # Controllers da API
│   ├── Models/                # Models Eloquent
│   └── ...
├── database/
│   ├── migrations/            # Migrations do banco
│   └── database.sqlite        # Banco SQLite
├── resources/
│   ├── js/                    # Código Vue.js
│   └── views/                 # Templates Blade
├── routes/
│   ├── api.php               # Rotas da API
│   └── web.php               # Rotas web
└── .devcontainer/            # Configuração do Dev Container
```

## 🌐 URLs de Acesso

- Laravel API: http://localhost:8000
- Vite Dev Server: http://localhost:5173

## 📝 Scripts NPM

```bash
npm run dev      # Inicia o Vite em modo desenvolvimento
npm run build    # Compila os assets para produção
```

## 🔧 Comandos Artisan Úteis

```bash
php artisan migrate              # Executar migrations
php artisan migrate:fresh        # Recriar banco do zero
php artisan db:seed              # Popular banco com dados
php artisan make:model NomeModel # Criar novo model
php artisan make:controller Nome # Criar novo controller
php artisan route:list           # Listar todas as rotas
php artisan cache:clear          # Limpar cache
php artisan config:clear         # Limpar cache de config
```

## 🐛 Troubleshooting

### Permissões de Arquivo

Se encontrar problemas de permissão:

```bash
chmod -R 775 storage bootstrap/cache
```

### Cache do Laravel

Se algo não funcionar como esperado:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Reinstalar Dependências

```bash
rm -rf vendor node_modules
composer install
npm install
```

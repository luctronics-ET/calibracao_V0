#!/bin/bash

################################################################################
# Script de Deploy - Sistema de Gestão de Calibração
# Autor: Sistema Automatizado
# Data: 29/11/2025
################################################################################

set -e

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funções de utilidade
print_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Verificar se está executando como root (se necessário)
check_permissions() {
    if [ "$EUID" -eq 0 ]; then 
        print_warning "Executando como root"
    fi
}

# Verificar dependências
check_dependencies() {
    print_info "Verificando dependências..."
    
    DEPS=("docker" "docker-compose" "git")
    
    for dep in "${DEPS[@]}"; do
        if ! command -v $dep &> /dev/null; then
            print_error "$dep não está instalado!"
            exit 1
        fi
    done
    
    print_success "Todas as dependências estão instaladas"
}

# Backup do banco de dados
backup_database() {
    print_info "Criando backup do banco de dados..."
    
    BACKUP_DIR="backups"
    mkdir -p $BACKUP_DIR
    
    BACKUP_FILE="$BACKUP_DIR/database_$(date +%Y%m%d_%H%M%S).sqlite"
    
    if [ -f "database/database.sqlite" ]; then
        cp database/database.sqlite $BACKUP_FILE
        print_success "Backup criado: $BACKUP_FILE"
    else
        print_warning "Banco de dados não encontrado, pulando backup"
    fi
}

# Atualizar código do repositório
update_code() {
    print_info "Atualizando código do repositório..."
    
    BRANCH=${1:-main}
    
    git fetch origin
    git checkout $BRANCH
    git pull origin $BRANCH
    
    print_success "Código atualizado da branch: $BRANCH"
}

# Instalar dependências PHP
install_dependencies() {
    print_info "Instalando dependências do Composer..."
    
    docker compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader
    
    print_success "Dependências instaladas"
}

# Executar migrações
run_migrations() {
    print_info "Executando migrações do banco de dados..."
    
    docker compose exec app php artisan migrate --force
    
    print_success "Migrações executadas"
}

# Limpar cache
clear_cache() {
    print_info "Limpando cache da aplicação..."
    
    docker compose exec app php artisan config:clear
    docker compose exec app php artisan cache:clear
    docker compose exec app php artisan route:clear
    docker compose exec app php artisan view:clear
    
    print_success "Cache limpo"
}

# Otimizar aplicação
optimize_app() {
    print_info "Otimizando aplicação..."
    
    docker compose exec app php artisan config:cache
    docker compose exec app php artisan route:cache
    docker compose exec app php artisan view:cache
    
    print_success "Aplicação otimizada"
}

# Reiniciar containers
restart_containers() {
    print_info "Reiniciando containers Docker..."
    
    docker compose down
    docker compose up -d
    
    print_success "Containers reiniciados"
}

# Verificar saúde da aplicação
health_check() {
    print_info "Verificando saúde da aplicação..."
    
    sleep 5
    
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8080/)
    
    if [ "$HTTP_CODE" -eq 200 ]; then
        print_success "Aplicação está funcionando! (HTTP $HTTP_CODE)"
    else
        print_error "Aplicação retornou HTTP $HTTP_CODE"
        exit 1
    fi
}

# Executar testes (opcional)
run_tests() {
    if [ "$RUN_TESTS" = true ]; then
        print_info "Executando testes automatizados..."
        
        docker compose exec app vendor/bin/phpunit --testdox
        
        if [ $? -eq 0 ]; then
            print_success "Todos os testes passaram"
        else
            print_warning "Alguns testes falharam, mas continuando deploy..."
        fi
    fi
}

# Menu de opções
show_menu() {
    echo ""
    echo "================================"
    echo "  Deploy - Sistema Calibração  "
    echo "================================"
    echo "1) Deploy Completo (Produção)"
    echo "2) Deploy Rápido (sem testes)"
    echo "3) Apenas atualizar código"
    echo "4) Apenas executar migrações"
    echo "5) Limpar cache"
    echo "6) Backup do banco de dados"
    echo "7) Health Check"
    echo "0) Sair"
    echo "================================"
    read -p "Escolha uma opção: " option
    
    case $option in
        1) deploy_full ;;
        2) deploy_quick ;;
        3) update_code ;;
        4) run_migrations ;;
        5) clear_cache ;;
        6) backup_database ;;
        7) health_check ;;
        0) exit 0 ;;
        *) print_error "Opção inválida!"; show_menu ;;
    esac
}

# Deploy completo
deploy_full() {
    print_info "🚀 Iniciando deploy completo..."
    echo ""
    
    check_permissions
    check_dependencies
    backup_database
    update_code
    install_dependencies
    run_migrations
    clear_cache
    optimize_app
    
    RUN_TESTS=true
    run_tests
    
    restart_containers
    health_check
    
    echo ""
    print_success "🎉 Deploy completo finalizado com sucesso!"
    echo ""
}

# Deploy rápido
deploy_quick() {
    print_info "⚡ Iniciando deploy rápido..."
    echo ""
    
    check_dependencies
    update_code
    install_dependencies
    clear_cache
    restart_containers
    health_check
    
    echo ""
    print_success "🎉 Deploy rápido finalizado!"
    echo ""
}

# Verificar argumentos da linha de comando
if [ $# -eq 0 ]; then
    show_menu
else
    case $1 in
        --full) deploy_full ;;
        --quick) deploy_quick ;;
        --update) update_code ;;
        --migrate) run_migrations ;;
        --cache) clear_cache ;;
        --backup) backup_database ;;
        --health) health_check ;;
        --help)
            echo "Uso: ./deploy.sh [opção]"
            echo ""
            echo "Opções:"
            echo "  --full      Deploy completo com testes"
            echo "  --quick     Deploy rápido sem testes"
            echo "  --update    Apenas atualizar código"
            echo "  --migrate   Apenas executar migrações"
            echo "  --cache     Limpar cache"
            echo "  --backup    Backup do banco de dados"
            echo "  --health    Verificar saúde da aplicação"
            echo "  --help      Mostrar esta ajuda"
            ;;
        *)
            print_error "Opção inválida! Use --help para ver as opções"
            exit 1
            ;;
    esac
fi

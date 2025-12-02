#!/bin/bash
# Script de utilidades para desenvolvimento
# Facilita backup e organização de arquivos de referência

set -e

REFERENCIAS_DIR="____referencias"
BACKUP_DIR="${REFERENCIAS_DIR}/backup"
NOTES_DIR="${REFERENCIAS_DIR}/notas"

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função para criar estrutura de diretórios
init_referencias() {
    echo -e "${GREEN}Criando estrutura de pastas de referência...${NC}"

    mkdir -p "${REFERENCIAS_DIR}"/{backup,exemplos,notas,relatorios,chat}

    if [ ! -f "${REFERENCIAS_DIR}/README" ]; then
        echo "# Pasta de Referências - Desenvolvimento" > "${REFERENCIAS_DIR}/README"
        echo "" >> "${REFERENCIAS_DIR}/README"
        echo "Veja DEVELOPMENT.md para mais informações." >> "${REFERENCIAS_DIR}/README"
    fi

    echo -e "${GREEN}✓ Estrutura criada com sucesso!${NC}"
    tree "${REFERENCIAS_DIR}" 2>/dev/null || ls -la "${REFERENCIAS_DIR}"
}

# Função para fazer backup de arquivo
backup_file() {
    if [ -z "$1" ]; then
        echo -e "${RED}Erro: Especifique o arquivo para backup${NC}"
        echo "Uso: $0 backup <arquivo>"
        exit 1
    fi

    FILE="$1"

    if [ ! -f "$FILE" ]; then
        echo -e "${RED}Erro: Arquivo '$FILE' não encontrado${NC}"
        exit 1
    fi

    mkdir -p "${BACKUP_DIR}"

    TIMESTAMP=$(date +%Y%m%d_%H%M%S)
    BASENAME=$(basename "$FILE")
    BACKUP_FILE="${BACKUP_DIR}/${BASENAME}.${TIMESTAMP}.backup"

    cp "$FILE" "$BACKUP_FILE"

    echo -e "${GREEN}✓ Backup criado: ${BACKUP_FILE}${NC}"
}

# Função para restaurar backup
restore_backup() {
    if [ -z "$1" ]; then
        echo -e "${YELLOW}Backups disponíveis:${NC}"
        ls -lh "${BACKUP_DIR}" 2>/dev/null || echo "Nenhum backup encontrado"
        exit 0
    fi

    BACKUP_FILE="$1"

    if [ ! -f "$BACKUP_FILE" ]; then
        echo -e "${RED}Erro: Backup '$BACKUP_FILE' não encontrado${NC}"
        exit 1
    fi

    # Extrair nome original do arquivo
    BASENAME=$(basename "$BACKUP_FILE" | sed 's/\.[0-9_]*\.backup$//')

    echo -e "${YELLOW}Restaurar '${BACKUP_FILE}' para '${BASENAME}'? (s/n)${NC}"
    read -r CONFIRM

    if [ "$CONFIRM" = "s" ] || [ "$CONFIRM" = "S" ]; then
        cp "$BACKUP_FILE" "$BASENAME"
        echo -e "${GREEN}✓ Arquivo restaurado: ${BASENAME}${NC}"
    else
        echo -e "${YELLOW}Operação cancelada${NC}"
    fi
}

# Função para criar nota
create_note() {
    if [ -z "$1" ]; then
        echo -e "${RED}Erro: Especifique o nome da nota${NC}"
        echo "Uso: $0 note <nome-da-nota>"
        exit 1
    fi

    mkdir -p "${NOTES_DIR}"

    NOTE_NAME="$1"
    NOTE_FILE="${NOTES_DIR}/${NOTE_NAME}.md"

    if [ -f "$NOTE_FILE" ]; then
        echo -e "${YELLOW}Nota já existe. Abrindo...${NC}"
    else
        cat > "$NOTE_FILE" << EOF
# ${NOTE_NAME}

**Data**: $(date +%Y-%m-%d)
**Autor**:

## Contexto



## Problema



## Solução



## Referências


EOF
        echo -e "${GREEN}✓ Nota criada: ${NOTE_FILE}${NC}"
    fi

    # Tentar abrir com editor
    if command -v code &> /dev/null; then
        code "$NOTE_FILE"
    elif [ -n "$EDITOR" ]; then
        $EDITOR "$NOTE_FILE"
    else
        echo "Abra o arquivo: $NOTE_FILE"
    fi
}

# Função para limpar backups antigos
clean_old_backups() {
    DAYS=${1:-30}

    echo -e "${YELLOW}Removendo backups com mais de ${DAYS} dias...${NC}"

    if [ ! -d "${BACKUP_DIR}" ]; then
        echo "Nenhum backup encontrado"
        exit 0
    fi

    find "${BACKUP_DIR}" -type f -mtime +${DAYS} -delete

    echo -e "${GREEN}✓ Limpeza concluída${NC}"
}

# Menu de ajuda
show_help() {
    cat << EOF
${GREEN}Script de Utilidades de Desenvolvimento${NC}

Uso: $0 <comando> [argumentos]

Comandos:
  init              Inicializa estrutura de pastas de referência
  backup <arquivo>  Cria backup de arquivo em ____referencias/backup/
  restore [arquivo] Restaura backup (lista backups se não especificar arquivo)
  note <nome>       Cria nova nota em ____referencias/notas/
  clean [dias]      Remove backups com mais de N dias (padrão: 30)
  help              Mostra esta ajuda

Exemplos:
  $0 init
  $0 backup app/Services/CalibracaoService.php
  $0 restore ____referencias/backup/CalibracaoService.php.20250101_143022.backup
  $0 note decisao-implementacao-igp
  $0 clean 60

EOF
}

# Main
case "${1:-}" in
    init)
        init_referencias
        ;;
    backup)
        backup_file "$2"
        ;;
    restore)
        restore_backup "$2"
        ;;
    note)
        create_note "$2"
        ;;
    clean)
        clean_old_backups "$2"
        ;;
    help|--help|-h)
        show_help
        ;;
    *)
        show_help
        exit 1
        ;;
esac

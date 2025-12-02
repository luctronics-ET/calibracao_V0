#!/bin/bash

# Script para corrigir permissões do Laravel
# Execute com: sudo bash fix-permissions.sh

echo "Corrigindo permissões do projeto Laravel..."

# Alterar proprietário para o usuário atual
chown -R $SUDO_USER:$SUDO_USER /home/luciano/Área\ de\ trabalho/dev/calibracao_V0

# Permissões para storage e bootstrap/cache
chmod -R 775 /home/luciano/Área\ de\ trabalho/dev/calibracao_V0/storage
chmod -R 775 /home/luciano/Área\ de\ trabalho/dev/calibracao_V0/bootstrap/cache

echo "✅ Permissões corrigidas com sucesso!"
echo ""
echo "Você pode agora voltar o SESSION_DRIVER para 'file' no .env se desejar"
echo "Ou manter como 'cookie' que também funciona bem"

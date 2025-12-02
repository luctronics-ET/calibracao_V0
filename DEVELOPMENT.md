# 🛠️ Guia de Desenvolvimento

## 📋 Estrutura do Projeto

### Pasta `____referencias/`

**Propósito**: Armazenamento de arquivos de referência exclusivamente para desenvolvimento.

**Uso Permitido**:

-   ✅ Documentação de desenvolvimento e anotações técnicas
-   ✅ Backup de arquivos durante refatoração
-   ✅ Exemplos de código e snippets de referência
-   ✅ Materiais de consulta e tutoriais
-   ✅ Resumos de conversas com IA (ChatGPT, etc)
-   ✅ Relatórios de implementação

**Restrições**:

-   ❌ NÃO deve conter código em execução no sistema
-   ❌ NÃO deve conter dados sensíveis ou credenciais
-   ❌ NÃO faz parte do build de produção
-   ❌ NÃO deve ser versionado no Git
-   ❌ NÃO deve ser incluído no Docker

**Configuração**:

A pasta está configurada para ser ignorada:

-   **Git**: Adicionado em `.gitignore`
-   **Docker**: Adicionado em `.dockerignore`

**Exemplo de Workflow**:

```bash
# 1. Backup antes de modificar arquivo crítico
cp app/Services/CalibracaoService.php \
   ____referencias/backup/CalibracaoService_$(date +%Y%m%d).php

# 2. Fazer modificações
vim app/Services/CalibracaoService.php

# 3. Se algo der errado, restaurar do backup
cp ____referencias/backup/CalibracaoService_20250101.php \
   app/Services/CalibracaoService.php
```

## 🔧 Boas Práticas

### Durante Refatoração

1. **Sempre faça backup** do arquivo original em `____referencias/backup/`
2. **Documente mudanças** significativas em `____referencias/notas/`
3. **Mantenha versões antigas** até confirmar que o novo código funciona
4. **Limpe backups antigos** após 30 dias ou quando não mais necessários

### Documentação de Decisões

Crie arquivos markdown em `____referencias/notas/` para documentar:

-   Escolhas técnicas importantes
-   Mudanças de arquitetura
-   Resolução de problemas complexos
-   Alternativas consideradas

Exemplo:

```markdown
# Decisão: Implementação da Matriz IGP

**Data**: 2025-01-15
**Autor**: Desenvolvedor

## Problema

Necessidade de priorizar calibrações automaticamente.

## Alternativas Consideradas

1. Classificação manual
2. Algoritmo baseado em pesos simples
3. Matriz IGP (escolhida)

## Justificativa

A matriz IGP fornece...
```

### Organização Sugerida

```
____referencias/
├── README                          # Documentação da pasta
├── backup/                         # Backups temporários
│   ├── CalibracaoService_20250101.php
│   └── UserController_20250115.php
├── exemplos/                       # Código de referência
│   ├── notificacao-alternativa.php
│   └── relatorio-excel.php
├── notas/                          # Anotações técnicas
│   ├── decisao-igp.md
│   └── problema-notificacoes.md
├── relatorios/                     # Relatórios de implementação
│   ├── implementacao-api.md
│   └── testes-realizados.md
└── chat/                          # Conversas com IA
    ├── gpt-metrologia.md
    └── gpt-sql-queries.md
```

## 🧪 Testes

### Executar Todos os Testes

```bash
php artisan test
```

### Executar Teste Específico

```bash
php artisan test --filter=CalibracaoTest
```

### Gerar Relatório de Cobertura

```bash
php artisan test --coverage
```

## 🚀 Deploy

### Checklist Antes do Deploy

-   [ ] Todos os testes passando
-   [ ] Migrations revisadas
-   [ ] `.env` de produção configurado
-   [ ] Pasta `____referencias/` não incluída (verificar `.dockerignore`)
-   [ ] Assets compilados (`npm run build`)
-   [ ] Cache limpo (`php artisan cache:clear`)

## 📝 Commits

### Padrão de Mensagens

```
tipo(escopo): mensagem curta

Descrição detalhada (opcional)

Closes #123
```

**Tipos**:

-   `feat`: Nova funcionalidade
-   `fix`: Correção de bug
-   `docs`: Documentação
-   `style`: Formatação
-   `refactor`: Refatoração
-   `test`: Testes
-   `chore`: Manutenção

**Exemplos**:

```
feat(calibracao): adicionar cálculo automático de IGP

fix(notificacao): corrigir envio duplicado de emails

docs(readme): atualizar instruções de instalação
```

## 🔍 Debug

### Laravel Telescope

```bash
# Instalar (apenas desenvolvimento)
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

### Logs

```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log

# Limpar logs antigos
php artisan log:clear
```

## 🐛 Resolução de Problemas

### Problema: Mudanças não aparecem

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Problema: Migrações não executam

```bash
# Verificar status
php artisan migrate:status

# Rollback última migration
php artisan migrate:rollback

# Fresh install (⚠️ apaga dados)
php artisan migrate:fresh --seed
```

### Problema: Assets não carregam

```bash
# Recompilar assets
npm run build

# Modo desenvolvimento com hot reload
npm run dev
```

## 📚 Recursos

-   [Laravel Documentation](https://laravel.com/docs)
-   [PHP The Right Way](https://phptherightway.com)
-   [Docker Documentation](https://docs.docker.com)

---

**Mantenha este documento atualizado conforme o projeto evolui!**

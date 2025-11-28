# Calibracao - Skeleton Laravel + Vue + SQLite

Este repositório contém um esqueleto **minimalista** para um sistema de gestão de calibração:
- backend: estrutura de arquivos Laravel (migrations, models, controllers, routes)
- frontend: Vue 3 com Vite (resources/js)
- banco: SQLite pronto (`database/database.sqlite`)
- objetivo: entregar um projeto offline *pronto para completar* e subir localmente.

**Observações importantes**
- Este zip *não* inclui dependências do Composer ou NPM (não é prático empacotar vendor/node_modules).
- Para executar o projeto completo, você precisa ter **PHP**, **Composer**, **Node.js** e **NPM/Yarn** instalados localmente.
- Instruções para preparar e rodar estão abaixo.

## Como preparar (passos sugeridos)
1. Descompacte este ZIP.
2. Copie `.env.example` para `.env` e ajuste se necessário.
3. Crie arquivo SQLite (já incluso em `database/database.sqlite`) ou apenas use o que está:
   ```
   touch database/database.sqlite
   ```
4. Instale dependências PHP:
   ```
   composer install
   ```
5. Instale dependências JS:
   ```
   npm install
   ```
6. Gere key do Laravel:
   ```
   php artisan key:generate
   ```
7. Rode migrations:
   ```
   php artisan migrate
   ```
8. Rode dev server (opcional):
   ```
   npm run dev
   php artisan serve --host=127.0.0.1 --port=8000
   ```
9. Acesse `http://127.0.0.1:8000`

## O que tem aqui (resumo)
- `app/Models` — modelos Eloquent: Equipamento, Calibracao, Laboratorio, Contrato, LoteEnvio, LoteItem, Usuario, Log, ParametroMetrologico
- `database/migrations` — migrations SQL correspondentes às tabelas discutidas
- `database/seeders` — seed com dados fictícios
- `resources/js` — Vue 3 app com componentes básicos (Dashboard, Equipamentos, Calibracoes)
- `routes/web.php` e `routes/api.php`
- `database/database.sqlite` — arquivo SQLite vazio (precriado)
- `README` — este arquivo

## Notas finais
Este esqueleto é pensado para acelerar o desenvolvimento. Sinta-se livre para adaptar nomes de tabelas, campos e relacionamentos ao seu contexto (p.ex. normas, escopos de acreditação, requisitos internos).

# Desafio Revvo — Backend PHP Puro + Front (Gulp)

## Requisitos
- PHP 8.x com PDO e SQLite (ou MySQL)
- Node 18+ (para Gulp)
- Servidor apontando para `public/`

## Setup rápido
1. Instalar dependências do front:
   ```bash
   npm i
   npm run build
## Rodar sem colocar no apache
   php -S 0.0.0.0:8000 -t public public/router.php


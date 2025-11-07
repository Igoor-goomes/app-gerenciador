<h1 align="center">🧮 Gerenciador de Produtos</h1>

<p align="center">
  Aplicação web para cadastro, listagem e gerenciamento de produtos, com foco em clareza de dados, múltiplas categorias e flexibilidade de atributos.<br>
  Desenvolvido em <b>Laravel (PHP 8+)</b> + <b>PostgreSQL</b> + <b>Docker/WSL2</b>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.3-blue?logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-11.x-red?logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PostgreSQL-15-blue?logo=postgresql" alt="PostgreSQL">
  <img src="https://img.shields.io/badge/Docker-ready-2496ED?logo=docker" alt="Docker">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License">
</p>

---

## ✅ Checklist de Configuração Rápida

| Etapa | Status |
|-------|--------|
| 🐙 Clonar o repositório | ✅ |
| 🐋 Subir containers com Docker | ✅ |
| 🧱 Instalar dependências (`composer install`) | ✅ |
| ⚙️ Configurar `.env` e gerar `APP_KEY` | ✅ |
| 🗃️ Rodar migrations e seeds | ✅ |
| 🧩 Corrigir permissões do `storage` (se necessário) | ✅ |
| 💻 Acessar em [http://localhost:8000](http://localhost:8000) | ✅ |

---

## 🧩 Principais Recursos

- Cadastro rápido via modal e telas dedicadas  
- Preço unitário (BRL) e total calculado (qtd × unitário)  
- Filtros dinâmicos com **DataTables Server-Side**  
- Categorias múltiplas e atributos flexíveis (JSON)  
- Feedback visual com **SweetAlert2** e **toasts**  
- Tabelas localizadas em PT-BR  

---

## 🐳 Como Executar (via Docker)

### 1️⃣ Clonar o repositório
```bash
git clone <URL_DO_REPOSITORIO>
cd <PASTA_DO_REPOSITORIO>
```

### 2️⃣ Subir a infraestrutura
> Use `docker compose` (sem hífen) — o padrão moderno do Docker.
```bash
docker compose up -d
```

### 3️⃣ Entrar no container da aplicação
```bash
docker exec -it app bash
```

### 4️⃣ Instalar dependências PHP e preparar o `.env`
```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 5️⃣ Configurar banco no `.env`
Use o serviço PostgreSQL do Docker:

```
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=gerenciador
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### 6️⃣ Rodar migrations e seeds
```bash
php artisan migrate --seed
```

### 7️⃣ Acessar no navegador
```
http://localhost:8000
```

---

## 🎨 Desenvolvimento Front-End (opcional)

Para recompilar CSS/JS no modo dev:
```bash
npm install
npm run dev
```

---

## 🔐 Autenticação

- Tela de login em `/signin`  
- Usuário inicial pode ser criado via **seed**  
- Exemplo de login:
  ```
  Email: admin@example.com
  Senha: password
  ```

---

## ⚙️ Estrutura e Notas

- **Backend:** Laravel + PHP 8+  
- **Frontend:** Blade + Bootstrap 5 + jQuery/DataTables  
- **Banco:** PostgreSQL (migrations e seeds)  
- **JS:** Lógica em `public/js/listaProdutos.js`  
- **Tabelas:** Localização PT-BR e colunas: Nome, Descrição, Preço Unitário, Total, Estoque, Ações  

---

## 🧰 Solução de Problemas Comuns

### ❗ Erro: “Please provide a valid cache path”
Ocorre quando o Laravel não encontra (ou não tem permissão) nas pastas de cache/views.

**Causa:** `storage/framework/views` ausente ou sem permissão.

**Como corrigir (dentro do container):**
```bash
docker exec -it app bash

mkdir -p storage/framework/{cache,data,sessions,testing,views}
mkdir -p bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

php artisan optimize:clear
```

Se necessário, adicione ao `.env`:
```
VIEW_COMPILED_PATH=/var/www/html/storage/framework/views
```

💡 Dica: use `docker compose stop` (não `down`) para manter permissões entre sessões.

---

## 🧱 Fluxo de Desenvolvimento

- Alterações de UI/JS → `public/js/listaProdutos.js`  
- Controllers organizam toda a lógica de CRUD e DataTables  
- Requests validam e normalizam preço/categorias/atributos  
- Controller principal: `ProdutoController@datatable`  

---

## 🪪 Licença

Uso educacional e de demonstração.  
---

<p align="center">Feito com ❤️ por <b>Igor Gomes</b> — Desenvolvedor PHP/Laravel</p>

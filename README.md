# Gerenciador de Produtos

Aplicação web para cadastro, listagem e gerenciamento de produtos, com foco em clareza de dados (preço unitário x total), categorias múltiplas e atributos flexíveis. Projeto feito em Laravel (PHP 8+), Blade/Bootstrap/jQuery no front, DataTables server-side, PostgreSQL, rodando em Docker/WSL.

## Principais Recursos
- Cadastro rápido por modal na Home e telas dedicadas de criar/editar
- Preço unitário com máscara BRL e total calculado (qtd × unitário)
- Filtros por nome, faixa de preço e estoque com DataTables server-side
- Categorias múltiplas e atributos chave/valor com casts JSON do Eloquent
- UX com toasts e confirmações (SweetAlert2) e tabelas com colunas localizadas em PT‑BR

## Como Executar
1) Clonar o repositório
```
git clone <URL_DO_REPOSITORIO>
cd <PASTA_DO_REPOSITORIO>
```

2) Subir infraestrutura com Docker
```
docker-compose up -d
```

3) Instalar dependências PHP e preparar o app (dentro da pasta `src`)
```
cd src
composer install
cp .env.example .env
php artisan key:generate
```

4) Configurar banco (variáveis do .env)
- Use o serviço do docker-compose (PostgreSQL) apontando `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

5) Rodar migrations e seeds
```
php artisan migrate --seed
```

6) Rodar o servidor
```
php artisan serve
```
A aplicação estará acessível em http://127.0.0.1:8000.

7) (Opcional) Front em modo dev com Vite
```
npm install
npm run dev
```

## Account/Autenticação
- Tela de Sign In disponível em `/signin` (ou navegação). Há seeder de usuário para acesso inicial quando aplicável.

## Estrutura e Notas
- Backend: Laravel + PHP 8+
- Frontend: Blade + Bootstrap 5 + jQuery/DataTables
- Banco: PostgreSQL (migrations e seeds)
- Máscara BRL, toasts e confirmações via JS em `src/public/js/listaProdutos.js`
- DataTables com localização PT‑BR e colunas: Nome, Descrição, Preço Unitário, Total, Estoque, Ações

## Fluxo de Desenvolvimento
- Alterações de UI/JS centralizadas em `src/public/js/listaProdutos.js` (evitar JS inline nas views)
- Requests validam e normalizam preço/categorias/atributos
- Controller `ProdutoController@datatable` fornece os dados da tabela (server-side)

## Licença
Uso educacional/demonstração. Ajuste conforme necessário.


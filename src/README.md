<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre este diretório (`src`)

Esta pasta contém o projeto Laravel (aplicação) em si. Para instruções completas de execução, veja o README na raiz do repositório. Abaixo, um resumo rápido do sistema e um mini‑manual de uso.

### Resumo do Sistema
- Gestão de produtos com:
  - Preço unitário (com máscara BRL) e total calculado (qtd × unitário)
  - Categorias múltiplas e atributos flexíveis (pares chave/valor)
  - Listagem com filtros e DataTables server‑side (PT‑BR)
  - Fluxo de criação rápido via modal na Home, além de telas Create/Edit
  - UX com toasts/confirm (SweetAlert2) e recarga automática de tabela

### Como mexer no sistema (atalhos)
- Home (Estoque): filtros por nome, preço mínimo/máximo e estoque; botão “Cadastro Novo Produto” abre a modal de criação.
- Criar/Editar: campos de Nome, Descrição, Preço Unitário, Quantidade, Categorias e Atributos. Botões “+ Adicionar” permitem múltiplas entradas.
- Listagem: colunas Nome, Descrição, Preço Unitário, Total, Estoque e Ações. A descrição é truncada com tooltip para manter legibilidade.
- Exclusão: confirmação bonita com SweetAlert2; ao confirmar, a tabela recarrega sem refresh da página.

### Onde ficam as coisas
- JS de UI/UX centralizado em `public/js/listaProdutos.js` (máscaras, toasts, confirmação, DataTables e modal)
- Views Blade em `resources/views` (layouts, páginas e parciais)
- Regras de validação/normalização em `app/Http/Requests`
- Controllers em `app/Http/Controllers`
- Modelo `Produto` com casts e total calculado em `app/Models/Produto.php`

### Rodar localmente (resumo)
1. `composer install` e configurar `.env`
2. `php artisan key:generate`
3. `php artisan migrate --seed`
4. `php artisan serve` (app disponível em http://127.0.0.1:8000)
5. (Opcional) `npm install && npm run dev` para Vite em dev

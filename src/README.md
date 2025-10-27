<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Projeto

Este projeto é um desafio técnico em Laravel focado em autenticação e organização de camadas. Ele expõe dois fluxos de acesso:

- Autenticação Web (sessão/cookies) para navegação no gerenciador.
- Autenticação via API REST (Bearer Token com Laravel Sanctum) para consumo programático.

## Stack e Versões
- PHP: ^8.2
- Laravel: ^11.31
- Sanctum: ^4.2 (tokens Bearer)
- Front-end: Blade + Bootstrap 5.3 (tema dark) + jQuery 3.7
- Banco de dados: SQLite (ambiente de desenvolvimento)

## Funcionalidades
- Web (guard `web`)
  - Tela de login em `/gerenciador/signin` (apenas convidados — middleware `guest`).
  - Home autenticada em `/gerenciador/home` (middleware `auth`).
  - Logout em `/gerenciador/logout` (POST), com invalidação de sessão e token CSRF.
  - Modal “Criar usuário” na tela de login chamando a API de registro.

- API (guard Sanctum)
  - `POST /api/v1/registrar`: cria usuário (validações e mensagens em português).
  - `POST /api/v1/login`: autentica e retorna token Bearer + dados do usuário.
  - `GET /api/v1/dados`: retorna dados do usuário autenticado (envie `Authorization: Bearer <token>`).
  - `POST /api/v1/logout`: revoga tokens do usuário autenticado.

## Organização
- Controllers Web: `app/Http/Controllers/GerenciadorController.php`
- Controllers API: `app/Http/Controllers/Api/AutenticadorController.php`
- Serviço de autenticação/usuário: `app/Services/AutenticadorService.php`
- Views: `resources/views` (layout dark, tela de login com modal e home)
- JS público: `public/js/signin.js` (lógica da modal de registro com jQuery)
- Rotas: `routes/web.php` (prefixo `/gerenciador`) e `routes/api.php` (prefixo `/api/v1`)

## Ambiente
- Desenvolvido para execução local (Laravel 11) com SQLite. As rotas Web usam CSRF/middleware padrão; as rotas API usam Sanctum (sem CSRF, com Bearer Token).

## Próximos Passos (Ideias)
- CRUD com DataTables (jQuery) e endpoints paginados.
- Extração das mensagens para `resources/lang` para i18n.
- Testes de feature para fluxos Web e API.

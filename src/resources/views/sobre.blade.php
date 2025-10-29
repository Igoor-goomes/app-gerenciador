@extends('layouts.layout')
@section('title', 'Sobre')
@section('content')
<div class="container py-4">
  <div class="row g-4">
    <div class="col-12">
      <h1 class="h4 mb-2">Sobre o Projeto</h1>
      <p class="mb-0 text-secondary">Este gerenciador de produtos nasceu como um desafio técnico e, acima de tudo, como um desafio pessoal</p>
    </div>

    <div class="col-md-6 order-md-2">
      <div class="card bg-body border-secondary-subtle h-100 shadow-sm">
        <div class="card-body">
          <h2 class="h6 text-uppercase text-secondary">Stack Técnica</h2>
          <ul class="mb-0 list-unstyled">
            <li class="mb-1"><i class="bi bi-cpu me-2 text-secondary"></i>Backend: <strong>Laravel {{ app()->version() }}</strong> + PHP 8+</li>
            <li class="mb-1"><i class="bi bi-window-sidebar me-2 text-secondary"></i>Frontend: <strong>Blade</strong> + Bootstrap 5 + jQuery/DataTables</li>
            <li class="mb-1"><i class="bi bi-database me-2 text-secondary"></i>Banco de Dados: <strong>PostgreSQL</strong></li>
            <li class="mb-1"><i class="bi bi-lightning-charge me-2 text-secondary"></i>Build/Dev: <strong>Vite</strong></li>
            <li class="mb-1"><i class="bi bi-box-seam me-2 text-secondary"></i>Ambiente: <strong>Docker</strong> + <strong>WSL</strong></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-6 order-md-1">
      <div class="card bg-body border-secondary-subtle h-100 shadow-sm">
        <div class="card-body">
          <h2 class="h6 text-uppercase text-secondary">Características Técnicas</h2>
          <ul class="mb-0 list-unstyled">
            <li class="mb-1"><i class="bi bi-diagram-3 me-2 text-secondary"></i>Migrations versionadas e seeds para dados iniciais</li>
            <li class="mb-1"><i class="bi bi-braces-asterisk me-2 text-secondary"></i>Casts nativos do Eloquent para JSON (categorias/atributos)</li>
            <li class="mb-1"><i class="bi bi-table me-2 text-secondary"></i>DataTables server-side para escala e responsividade</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card bg-body border-secondary-subtle shadow-sm">
        <div class="card-body">
          <h2 class="h6 text-uppercase text-secondary">Motivação</h2>
          <p class="mb-2">Além de cumprir o desafio técnico, este projeto foi uma oportunidade de:</p>
          <div class="row mot-grid">
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-mortarboard me-2 text-secondary"></i>Reforçar fundamentos</div></div>
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-clipboard-check me-2 text-secondary"></i>Exercitar boas práticas</div></div>
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-stars me-2 text-secondary"></i>Explorar tecnologias novas</div></div>
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-briefcase me-2 text-secondary"></i>Resolver um problema real</div></div>
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-diagram-3 me-2 text-secondary"></i>Aprimorar modelagem de domínio (preço unitário x total, categorias e atributos flexíveis)</div></div>
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-mouse me-2 text-secondary"></i>Praticar UX (máscaras, toasts, confirmações e DataTables server-side)</div></div>
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-check2-square me-2 text-secondary"></i>Consolidar padrões de código limpo em Laravel (Requests, Services e Controllers)</div></div>
            <div class="col-12 col-md-6"><div class="mot-item"><i class="bi bi-graph-up-arrow me-2 text-secondary"></i>Iterar com incrementos pequenos e feedback rápido</div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

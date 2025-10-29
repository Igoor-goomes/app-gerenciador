@extends('layouts.layout')
@section('title', 'Contato')
@section('content')
<div class="container py-4">
  <div class="row g-4">
    <div class="col-12">
      <h1 class="h4 mb-2">Contato</h1>
      <p class="text-secondary mb-0">Fico à disposição para trocarmos ideias, feedbacks e oportunidades.</p>
    </div>

    <div class="col-lg-8 col-xl-6">
      <div class="card bg-body border-secondary-subtle shadow-sm">
        <div class="card-body">
          <h2 class="h6 text-uppercase text-secondary mb-3">Canais</h2>
          <ul class="list-unstyled m-0">
            <li class="mb-2">
              <i class="bi bi-envelope me-2 text-secondary"></i>
              <a href="mailto:seuemail@exemplo.com" class="link-light text-decoration-none">igorgomesdebrito@gmail.com</a>
            </li>
            <li class="mb-2">
              <i class="bi bi-telephone me-2 text-secondary"></i>
              <a href="https://wa.me/5599999999999" target="_blank" class="link-light text-decoration-none">(99) 99597-8558 (WhatsApp)</a>
            </li>
            <li class="mb-2">
              <i class="bi bi-linkedin me-2 text-secondary"></i>
              <a href="https://www.linkedin.com/in/seu-perfil" target="_blank" class="link-light text-decoration-none">linkedin.com/in/igor-gomes-de-brito</a>
            </li>
            <li class="mb-2">
              <i class="bi bi-github me-2 text-secondary"></i>
              <a href="https://github.com/seu-usuario/seu-repositorio" target="_blank" class="link-light text-decoration-none">github.com/Igoor-goomes/app-gerenciador</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

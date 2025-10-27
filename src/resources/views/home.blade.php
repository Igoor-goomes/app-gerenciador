@extends('layouts.layout')
@section('title', 'Home')
@section('content')
<nav class="navbar navbar-expand-lg bg-body-tertiary mb-4 border-bottom border-secondary-subtle">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">Gerenciador</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Serviços</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contato</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Perfil</a>
        </li>
      </ul>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger">Sair</button>
      </form>
    </div>
  </div>
  </nav>

<div class="container">
  <div class="row">
    <div class="col">
      <div class="p-4 border rounded-3 border-secondary-subtle">
        <h1 class="h4 mb-2">Bem-vindo</h1>
        <p class="text-secondary mb-0">Você está autenticado no Gerenciador.</p>
      </div>
    </div>
  </div>
</div>
@endsection


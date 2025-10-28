@extends('layouts.layout')
@section('title', 'Sign In')
@section('content')
<div class="container py-4 min-vh-100 d-flex flex-column">
  <div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
      Criar usuário
    </button>
  </div>
  <div class="row flex-fill justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
      <div class="card shadow-sm bg-body border-secondary-subtle">
        <div class="card-body">
          <h1 class="h4 mb-1 text-center">Gerenciador de Produtos</h1>
          <p class="text-secondary text-center mb-4">Entre com suas credenciais</p>

          @if ($errors->any())
            <div class="alert alert-danger">
              {{ $errors->first() }}
            </div>
          @endif

          <div id="signinAlert" class="alert alert-success d-none" role="alert"></div>

          <form method="POST" action="{{ route('signin.form') }}">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">E-mail</label>
              <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="form-control @error('email') is-invalid @enderror"
              >
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-4">
              <label for="password" class="form-label">Senha</label>
              <input
                type="password"
                id="password"
                name="password"
                required
                class="form-control @error('password') is-invalid @enderror"
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
              Entrar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Registrar Usuário -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-body border-secondary-subtle">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalRegistrarLabel">Criar usuário</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="registerErrors" class="alert alert-danger d-none"></div>
        <form id="registerForm">
          <div class="mb-3">
            <label for="reg_nome" class="form-label">Nome</label>
            <input type="text" id="reg_nome" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="reg_email" class="form-label">E-mail</label>
            <input type="email" id="reg_email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="reg_password" class="form-label">Senha</label>
            <input type="password" id="reg_password" name="password" class="form-control" minlength="6" required>
          </div>
          <div class="mb-3">
            <label for="reg_password_confirmation" class="form-label">Confirmar senha</label>
            <input type="password" id="reg_password_confirmation" name="password_confirmation" class="form-control" minlength="6" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btnRegistrar" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
  </div>

@section('scripts')
<script src="/js/signin.js"></script>
@endsection
@endsection

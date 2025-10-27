@extends('layouts.layout')
@section('title', 'Sign In')
@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
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
@endsection

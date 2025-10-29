@extends('layouts.layout')
@section('title', 'Detalhes do Produto')
@section('content')
<div class="container py-4">
  <h1 class="h4 mb-3">Detalhes do Produto</h1>

  <div class="card bg-body border-secondary-subtle shadow-sm">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Nome</dt>
        <dd class="col-sm-9">{{ $produto->nome }}</dd>

        <dt class="col-sm-3">Descrição</dt>
        <dd class="col-sm-9">{{ $produto->descricao ?: '-' }}</dd>

        <dt class="col-sm-3">Preço</dt>
        <dd class="col-sm-9">R$ {{ number_format((float) $produto->preco, 2, ',', '.') }}</dd>

        <dt class="col-sm-3">Quantidade em Estoque</dt>
        <dd class="col-sm-9">{{ $produto->quantidade_estoque }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar</a>
      <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-primary">Editar</a>
    </div>
  </div>
</div>
@endsection

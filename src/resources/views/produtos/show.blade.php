@extends('layouts.layout')
@section('title', 'Detalhes do Produto')
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 m-0">{{ $produto->nome }}</h1>
    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-primary">Editar</a>
  </div>

  <div class="card bg-body border-secondary-subtle shadow-sm p-3">
    <div class="mb-2"><strong>Descrição:</strong> {{ $produto->descricao ?? '-' }}</div>
    <div class="mb-2"><strong>Preço Unitário:</strong> R$ {{ number_format((float)($produto->preco_unitario ?? $produto->preco), 2, ',', '.') }}</div>
    <div class="mb-2"><strong>Quantidade em estoque:</strong> {{ $produto->quantidade_estoque }}</div>
    <div class="mb-2"><strong>Total:</strong> R$ {{ number_format((float) $produto->preco_total, 2, ',', '.') }}</div>

    <div class="mb-2">
      <strong>Categorias:</strong>
      @php($cats = $produto->categoria ?? [])
      @if(!empty($cats))
        @foreach($cats as $c)
          <span class="badge text-bg-secondary me-1">{{ $c }}</span>
        @endforeach
      @else
        <span>-</span>
      @endif
    </div>

    <div class="mb-2">
      <strong>Atributos:</strong>
      @php($attrs = $produto->atributo ?? [])
      @if(!empty($attrs) && is_array($attrs))
        <ul class="mb-0">
          @foreach($attrs as $k=>$v)
            <li><strong>{{ is_int($k)? '—' : $k }}:</strong> {{ is_array($v) ? json_encode($v) : $v }}</li>
          @endforeach
        </ul>
      @else
        <span>-</span>
      @endif
    </div>
  </div>

  <div class="mt-3">
    <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar</a>
  </div>
  </div>
@endsection

@extends('layouts.layout')
@section('title', 'Editar Produto')
@section('content')
<div class="container py-4">
  <h1 class="h4 mb-3">Editar Produto</h1>

  <form method="POST" action="{{ route('produtos.update', $produto) }}" class="card bg-body border-secondary-subtle shadow-sm p-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" value="{{ old('nome', $produto->nome) }}" class="form-control @error('nome') is-invalid @enderror" required>
      @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Descrição</label>
      <textarea name="descricao" rows="3" class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao', $produto->descricao) }}</textarea>
      @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="row g-3">
      <div class="col-sm-4">
        <label class="form-label">Preço Unitário</label>
        <input type="text" name="preco" value="{{ old('preco', number_format((float)($produto->preco_unitario ?? $produto->preco), 2, ',', '.')) }}" class="form-control @error('preco') is-invalid @enderror" placeholder="R$ 0,00" required>
        @error('preco')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-sm-4">
        <label class="form-label">Quantidade em Estoque</label>
        <input type="number" step="1" min="0" name="quantidade_estoque" value="{{ old('quantidade_estoque', $produto->quantidade_estoque) }}" class="form-control @error('quantidade_estoque') is-invalid @enderror" required>
        @error('quantidade_estoque')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-sm-4">
        <label class="form-label">Total</label>
        <input type="text" class="form-control" value="R$ {{ number_format((float) ($produto->preco_total), 2, ',', '.') }}" readonly>
      </div>
    </div>

    <div class="mt-4 d-flex gap-2">
      <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar</a>
      <button class="btn btn-primary">Salvar</button>
    </div>
  </form>
</div>
@endsection
@section('scripts')
<script src="/js/listaProdutos.js"></script>
@endsection

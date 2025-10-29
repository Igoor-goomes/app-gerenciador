@extends('layouts.layout')
@section('title', 'Novo Produto')
@section('content')
<div class="container py-4">
  <h1 class="h4 mb-3">Novo Produto</h1>

  <form method="POST" action="{{ route('produtos.store') }}" class="card bg-body border-secondary-subtle shadow-sm p-3">
    @csrf

    <div class="mb-3">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror" required>
      @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Descrição</label>
      <textarea name="descricao" rows="3" class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao') }}</textarea>
      @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="row g-3">
      <div class="col-sm-6">
        <label class="form-label">Preço Unitário</label>
        <input type="text" name="preco" value="{{ old('preco') }}" class="form-control @error('preco') is-invalid @enderror" placeholder="R$ 0,00" required>
        @error('preco')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-sm-6">
        <label class="form-label">Quantidade em Estoque</label>
        <input type="number" step="1" min="0" name="quantidade_estoque" value="{{ old('quantidade_estoque') }}" class="form-control @error('quantidade_estoque') is-invalid @enderror" required>
        @error('quantidade_estoque')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="mt-3">
      <label class="form-label">Categorias</label>
      <div id="categorias-wrapper-create">
        <input type="text" name="categoria[]" class="form-control mb-2" placeholder="Ex.: Eletrônicos">
      </div>
      <button class="btn btn-sm btn-outline-secondary" type="button" onclick="addCategoriaFieldCreate()">+ Adicionar categoria</button>
    </div>

    <div class="mt-3">
      <label class="form-label">Atributos</label>
      <div id="atributos-wrapper-create">
        <div class="row g-2 align-items-center mb-2">
          <div class="col"><input type="text" class="form-control" name="atributo[chave][]" placeholder="Chave (ex.: marca)"></div>
          <div class="col"><input type="text" class="form-control" name="atributo[valor][]" placeholder="Valor (ex.: ACME)"></div>
        </div>
      </div>
      <button class="btn btn-sm btn-outline-secondary" type="button" onclick="addAtributoFieldCreate()">+ Adicionar atributo</button>
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
<script src="/js/listaProdutos.js"></script>
@endsection

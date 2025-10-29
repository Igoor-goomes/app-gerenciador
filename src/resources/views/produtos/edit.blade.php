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
      <div class="col-sm-6">
        <label class="form-label">Preço</label>
        <input type="number" step="0.01" min="0" name="preco" value="{{ old('preco', $produto->preco) }}" class="form-control @error('preco') is-invalid @enderror" required>
        @error('preco')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="col-sm-6">
        <label class="form-label">Quantidade em Estoque</label>
        <input type="number" step="1" min="0" name="quantidade_estoque" value="{{ old('quantidade_estoque', $produto->quantidade_estoque) }}" class="form-control @error('quantidade_estoque') is-invalid @enderror" required>
        @error('quantidade_estoque')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
<script>
  $(function(){
    const $preco = $("input[name='preco']");
    if (typeof applyMoneyMask === 'function') {
      applyMoneyMask($preco);
      // formata valor inicial caso venha como número
      const val = $preco.val();
      if (val && typeof formatMoneyBRFromDigits === 'function') {
        const digits = String(Math.round(parseFloat(val) * 100));
        $preco.val(formatMoneyBRFromDigits(digits));
      }
    }
    $("form").on('submit', function(){
      if (typeof parseMoneyToNumber === 'function') {
        const $p = $(this).find("input[name='preco']");
        $p.val(parseMoneyToNumber($p.val()));
      }
    });
  });
</script>
@endsection

@extends('layouts.layout')
@section('title', 'Home')

@section('content')

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 m-0">Estoque</h1>
            <button type="button" id="btnAbrirModalNovoProduto" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoProduto">Cadastro Novo Produto</button>
        </div>
        <form method="GET" class="mb-3">
            <div class="row g-2 align-items-end">
                <div class="col-sm-6 col-md-4 col-lg-3"> <label class="form-label">Nome</label> <input type="text"
                        name="q" class="form-control" placeholder="Buscar por nome"> </div>
                <div class="col-sm-3 col-md-2 col-lg-2"> <label class="form-label">Preço mínimo</label> <input
                        type="text" name="preco_min" class="form-control" placeholder="R$ 0,00"> </div>
                <div class="col-sm-3 col-md-2 col-lg-2"> <label class="form-label">Preço máximo</label> <input
                        type="text" name="preco_max" class="form-control" placeholder="R$ 0,00"> </div>
                <div class="col-sm-3 col-md-2 col-lg-2"> <label class="form-label">Estoque mín.</label> <input
                        type="number" name="estoque_min" step="1" min="0" class="form-control" placeholder="Ex.: 0"> </div>
                <div class="col-sm-3 col-md-2 col-lg-2"> <label class="form-label">Estoque máx.</label> <input
                        type="number" name="estoque_max" step="1" min="0" class="form-control" placeholder="Ex.: 100"> </div>
                <div class="col-auto"> <button class="btn btn-outline-secondary" type="submit">Filtrar</button> </div>
            </div>
        </form>
        <div class="card bg-body border-secondary-subtle shadow-sm">
            <div class="table-responsive">
                <table id="tabela-dashboard" class="table table-dark table-hover table-sm align-middle mb-0"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th data-data="nome">Nome</th>
                            <th data-data="descricao">Descrição</th>
                            <th data-data="preco" class="text-end">Preço Unitário</th>
                            <th data-data="total" class="text-end">Total</th>
                            <th data-data="quantidade_estoque" class="text-end">Estoque</th>
                            <th data-data="acoes" class="text-end" style="width: 180px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Modal Novo Produto -->
        <div class="modal fade" id="modalNovoProduto" tabindex="-1" aria-labelledby="modalNovoProdutoLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content bg-body border-secondary-subtle">
              <div class="modal-header">
                <h5 class="modal-title" id="modalNovoProdutoLabel">Novo Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="formNovoProduto" method="POST" action="{{ route('produtos.store') }}">
                @csrf
                <div class="modal-body">
                  <div id="novoProdutoErrors" class="alert alert-danger d-none"></div>

                  <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" rows="3" class="form-control"></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Categorias</label>
                    <div id="categorias-wrapper">
                      <input type="text" name="categoria[]" class="form-control mb-2" placeholder="Ex.: Eletrônicos">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-action="add-categoria" data-target="#categorias-wrapper">+ Adicionar categoria</button>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Atributos</label>
                    <div id="atributos-wrapper">
                      <div class="row g-2 align-items-center mb-2">
                        <div class="col"><input type="text" class="form-control" name="atributo[chave][]" placeholder="Chave (ex.: marca)"></div>
                        <div class="col"><input type="text" class="form-control" name="atributo[valor][]" placeholder="Valor (ex.: ACME)"></div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-action="add-atributo" data-target="#atributos-wrapper">+ Adicionar atributo</button>
                  </div>

                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label class="form-label">Preço Unitário</label>
                      <input type="text" name="preco" class="form-control" placeholder="R$ 0,00" autocomplete="off" required>
                    </div>
                    <div class="col-sm-6">
                      <label class="form-label">Quantidade em Estoque</label>
                      <input type="number" step="1" min="0" name="quantidade_estoque" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
</div> @endsection
@section('scripts')

    <script src="/js/listaProdutos.js"></script>
@endsection

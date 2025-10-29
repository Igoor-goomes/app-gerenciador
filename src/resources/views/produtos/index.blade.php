@extends('layouts.layout')
@section('title', 'Produtos')
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 m-0">Produtos</h1>
    <a href="{{ route('produtos.create') }}" class="btn btn-primary">Novo Produto</a>
  </div>

  <form method="GET" class="mb-3">
    <div class="row g-2 align-items-end">
      <div class="col-sm-6 col-md-4 col-lg-3">
        <label class="form-label">Nome</label>
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar por nome">
      </div>
      <div class="col-sm-3 col-md-2 col-lg-2">
        <label class="form-label">Preço mínimo</label>
        <input type="number" name="preco_min" step="0.01" min="0" value="{{ $f['preco_min'] ?? '' }}" class="form-control">
      </div>
      <div class="col-sm-3 col-md-2 col-lg-2">
        <label class="form-label">Preço máximo</label>
        <input type="number" name="preco_max" step="0.01" min="0" value="{{ $f['preco_max'] ?? '' }}" class="form-control">
      </div>
      <div class="col-sm-3 col-md-2 col-lg-2">
        <label class="form-label">Estoque mín.</label>
        <input type="number" name="estoque_min" step="1" min="0" value="{{ $f['estoque_min'] ?? '' }}" class="form-control">
      </div>
      <div class="col-sm-3 col-md-2 col-lg-2">
        <label class="form-label">Estoque máx.</label>
        <input type="number" name="estoque_max" step="1" min="0" value="{{ $f['estoque_max'] ?? '' }}" class="form-control">
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
      </div>
    </div>
  </form>

  <div class="card bg-body border-secondary-subtle shadow-sm">
    <div class="table-responsive">
      <table id="tabela-produtos" class="table table-dark table-hover table-sm align-middle mb-0" style="width:100%">
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
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script>
  $(function(){
    const tabela = $('#tabela-produtos').DataTable({
      processing: true,
      serverSide: true,
      paging: true,
      searching: false,
      info: true,
      ajax: {
        url: '{{ route('produtos.datatable') }}',
        data: function (d) {
          d.q = $('input[name="q"]').val();
          d.preco_min = $('input[name="preco_min"]').val();
          d.preco_max = $('input[name="preco_max"]').val();
          d.estoque_min = $('input[name="estoque_min"]').val();
          d.estoque_max = $('input[name="estoque_max"]').val();
        }
      },
      columns: [
        { data: 'nome', name: 'nome' },
        { data: 'descricao', name: 'descricao', render: function(data, type){
            if (type === 'display' || type === 'filter') {
              const text = data || '-';
              return '<span class="dt-desc-ellipsis" title="'+ $('<div>').text(text).html() +'">'+ $('<div>').text(text).html() +'</span>';
            }
            return data;
          }
        },
        { data: 'preco', name: 'preco', className: 'text-end' },
        { data: 'total', name: 'total', className: 'text-end' },
        { data: 'quantidade_estoque', name: 'quantidade_estoque', className: 'text-end' },
        { data: 'acoes', name: 'acoes', orderable: false, searchable: false, className: 'text-end' },
      ],
      order: []
    });

    // Recarrega ao enviar filtros
    $('form').on('submit', function(e){
      e.preventDefault();
      tabela.ajax.reload();
    });
  });
  </script>
@endsection

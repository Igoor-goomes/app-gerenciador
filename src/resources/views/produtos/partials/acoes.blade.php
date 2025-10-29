<div class="d-inline-flex gap-1 flex-nowrap">
  <a href="{{ route('produtos.show', $p) }}" class="btn btn-sm btn-primary">Detalhar</a>
  <a href="{{ route('produtos.edit', $p) }}" class="btn btn-sm btn-success">Editar</a>
  <form action="{{ route('produtos.destroy', $p) }}" method="POST" class="d-inline form-delete-produto">
  @csrf
  @method('DELETE')
  <button class="btn btn-sm btn-danger">Excluir</button>
  </form>
</div>

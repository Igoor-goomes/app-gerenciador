<?php

namespace App\Services;

use App\Models\Produto;

class ProdutoService
{
    public function listarPaginado(array $filtros = [], int $porPagina = 10)
    {
        $q = Produto::query();

        if (!empty($filtros['nome'])) {
            $termo = trim((string) $filtros['nome']);
            $q->where('nome', 'like', '%'.$termo.'%');
        }

        if (isset($filtros['preco_min']) && $filtros['preco_min'] !== '') {
            $q->where('preco', '>=', (float) $filtros['preco_min']);
        }
        if (isset($filtros['preco_max']) && $filtros['preco_max'] !== '') {
            $q->where('preco', '<=', (float) $filtros['preco_max']);
        }

        if (isset($filtros['estoque_min']) && $filtros['estoque_min'] !== '') {
            $q->where('quantidade_estoque', '>=', (int) $filtros['estoque_min']);
        }
        if (isset($filtros['estoque_max']) && $filtros['estoque_max'] !== '') {
            $q->where('quantidade_estoque', '<=', (int) $filtros['estoque_max']);
        }

        return $q->orderByDesc('id')->paginate($porPagina)->withQueryString();
    }

    public function criar(array $dados): Produto
    {
        return Produto::create($dados);
    }

    public function atualizar(Produto $produto, array $dados): Produto
    {
        $produto->update($dados);
        return $produto;
    }

    public function excluir(Produto $produto): void
    {
        $produto->delete();
    }
}


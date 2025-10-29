<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Services\ProdutoService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProdutoStoreRequest;
use App\Http\Requests\ProdutoUpdateRequest;

class ProdutoController extends Controller
{
    use ApiResponse;

    public function index(Request $request, ProdutoService $service)
    {
        $filtros = [
            'nome'        => $request->get('nome'),
            'preco_min'   => $request->get('preco_min'),
            'preco_max'   => $request->get('preco_max'),
            'estoque_min' => $request->get('estoque_min'),
            'estoque_max' => $request->get('estoque_max'),
        ];

        $produtos = $service->listarPaginado($filtros, (int) $request->get('per_page', 10));
        return $this->success($produtos, 'Lista de produtos');
    }

    public function store(ProdutoStoreRequest $request, ProdutoService $service)
    {
        $produto = $service->criar($request->validated());
        return $this->success($produto, 'Produto criado', 201);
    }

    public function show(Produto $produto)
    {
        return $this->success($produto, 'Produto');
    }

    public function update(ProdutoUpdateRequest $request, Produto $produto, ProdutoService $service)
    {
        $service->atualizar($produto, $request->validated());
        return $this->success($produto->fresh(), 'Produto atualizado');
    }

    public function destroy(Produto $produto, ProdutoService $service)
    {
        $service->excluir($produto);
        return $this->success(null, 'Produto removido');
    }
}


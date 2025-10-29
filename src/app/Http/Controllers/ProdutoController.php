<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use App\Http\Requests\ProdutoStoreRequest;
use App\Http\Requests\ProdutoUpdateRequest;

class ProdutoController extends Controller
{
    public function index(Request $request, ProdutoService $service)
    {
        $filtros = [
            'nome'        => $request->get('q'),
            'preco_min'   => $request->get('preco_min'),
            'preco_max'   => $request->get('preco_max'),
            'estoque_min' => $request->get('estoque_min'),
            'estoque_max' => $request->get('estoque_max'),
        ];

        $produtos = $service->listarPaginado($filtros, 10);
        return view('produtos.index', [
            'produtos' => $produtos,
            'q' => (string) ($filtros['nome'] ?? ''),
            'f' => $filtros,
        ]);
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(ProdutoStoreRequest $request)
    {
        Produto::create($request->validated());
        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso.');
    }

    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    public function update(ProdutoUpdateRequest $request, Produto $produto)
    {
        $produto->update($request->validated());
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso.');
    }

    // DataTables server-side endpoint
    public function datatable(Request $request, ProdutoService $service)
    {
        $draw   = (int) $request->input('draw', 1);
        $start  = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $filtros = [
            'nome'        => $request->input('q'),
            'preco_min'   => $request->input('preco_min'),
            'preco_max'   => $request->input('preco_max'),
            'estoque_min' => $request->input('estoque_min'),
            'estoque_max' => $request->input('estoque_max'),
        ];

        // Base query via service (sem paginação), para podermos contar e paginar manualmente
        $query = \App\Models\Produto::query();
        if (!empty($filtros['nome'])) {
            $query->where('nome', 'like', '%'.trim($filtros['nome']).'%');
        }
        if ($filtros['preco_min'] !== null && $filtros['preco_min'] !== '') {
            $query->where('preco', '>=', (float) $filtros['preco_min']);
        }
        if ($filtros['preco_max'] !== null && $filtros['preco_max'] !== '') {
            $query->where('preco', '<=', (float) $filtros['preco_max']);
        }
        if ($filtros['estoque_min'] !== null && $filtros['estoque_min'] !== '') {
            $query->where('quantidade_estoque', '>=', (int) $filtros['estoque_min']);
        }
        if ($filtros['estoque_max'] !== null && $filtros['estoque_max'] !== '') {
            $query->where('quantidade_estoque', '<=', (int) $filtros['estoque_max']);
        }

        $recordsTotal = \App\Models\Produto::count();

        // Ordenação do DataTables
        $order = $request->input('order', []);
        $columns = $request->input('columns', []);
        if (!empty($order)) {
            foreach ($order as $ord) {
                $colIndex = (int) ($ord['column'] ?? 0);
                $dir = ($ord['dir'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
                $colName = $columns[$colIndex]['data'] ?? $columns[$colIndex]['name'] ?? null;
                // Mapear possíveis nomes de coluna
                $allowed = ['nome','preco','quantidade_estoque','id'];
                if ($colName && in_array($colName, $allowed, true)) {
                    $query->orderBy($colName, $dir);
                }
            }
        } else {
            $query->orderByDesc('id');
        }

        $recordsFiltered = (clone $query)->count();
        $data = $query->skip($start)->take($length)->get()->map(function ($p) {
            return [
                'nome' => $p->nome,
                'preco' => 'R$ ' . number_format((float) $p->preco, 2, ',', '.'),
                'quantidade_estoque' => $p->quantidade_estoque,
                'acoes' => view('produtos.partials.acoes', ['p' => $p])->render(),
            ];
        });

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}

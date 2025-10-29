<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdutoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeTarget = $this->route('produto') ?? $this->route('id') ?? null;
        $produtoId = is_object($routeTarget) ? $routeTarget->getKey() : $routeTarget;

        $sometimes = $this->isMethod('patch') ? 'sometimes' : 'required';

        return [
            'nome'               => [$sometimes, 'string', 'max:255', Rule::unique('produtos', 'nome')->ignore($produtoId)],
            'descricao'          => ['nullable', 'string'],
            'preco'              => [$sometimes, 'numeric', 'min:0'],
            'quantidade_estoque' => [$sometimes, 'integer', 'min:0'],
            'categoria'          => ['nullable', 'array'],
            'atributo'           => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'                   => 'O campo :attribute é obrigatório.',
            'nome.unique'                => 'Já existe um produto com este nome.',
            'preco.numeric'              => 'O preço deve ser numérico.',
            'preco.min'                  => 'O preço deve ser maior ou igual a zero.',
            'quantidade_estoque.integer' => 'A quantidade em estoque deve ser um número inteiro.',
            'quantidade_estoque.min'     => 'A quantidade em estoque não pode ser negativa.',
            'categoria.array'            => 'Categoria deve ser um array.',
            'atributo.array'             => 'Atributo deve ser um array.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nome'               => 'nome',
            'descricao'          => 'descrição',
            'preco'              => 'preço',
            'quantidade_estoque' => 'quantidade em estoque',
            'categoria'          => 'categoria',
            'atributo'           => 'atributo',
        ];
    }

    protected function prepareForValidation(): void
    {
        $preco = $this->input('preco');
        if (is_string($preco)) {
            $preco = str_replace(['.', ','], ['', '.'], preg_replace('/\s+/', '', $preco));
        }

        $this->merge([
            'nome'               => trim((string) $this->input('nome')),
            'descricao'          => $this->filled('descricao') ? trim((string) $this->input('descricao')) : null,
            'preco'              => $preco,
            'quantidade_estoque' => $this->input('quantidade_estoque'),
            'categoria'          => $this->input('categoria') ?? null,
            'atributo'           => $this->input('atributo') ?? null,
        ]);
    }
}

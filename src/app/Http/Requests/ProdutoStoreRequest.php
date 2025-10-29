<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdutoStoreRequest extends FormRequest
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
        return [
            'nome'               => ['required', 'string', 'max:255', 'unique:produtos,nome'],
            'descricao'          => ['nullable', 'string'],
            'preco'              => ['required', 'numeric', 'min:0'],
            'quantidade_estoque' => ['required', 'integer', 'min:0'],
            'categoria'          => ['nullable', 'array'],
            'atributo'           => ['nullable', 'array']
        ];
    }

    /**
     * Define mensagens de erro personalziadas
     * @return array
     */
    public function messages(): array
    {
        return [
            'required'                    => 'O campo :attribute é obrigatório.',
            'nome.unique'                 => 'Já existe um produto com este nome.',
            'preco.numeric'               => 'O :attribute deve ser numérico.',
            'preco.min'                   => 'O :attribute deve ser maior ou igual a zero.',
            'quantidade_estoque.required' => 'A :attribute é obrigatória.',
            'quantidade_estoque.integer'  => 'A :attribute deve ser um número inteiro.',
            'quantidade_estoque.min'      => 'A :attribute deve ser maior ou igual a zero.',
            'categoria.array'             => 'Categoria deve ser um array.',
            'atributo.array'              => 'Atributo deve ser um array.',
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
            'atributo'           => 'atributo'
        ];
    }

    protected function prepareForValidation(): void {
        $preco = $this->input('preco');

        if (is_string($preco)) {
            $preco = str_replace(['.', ','], ['', '.'], preg_replace('/\s+/', '', $preco)); // 1.234,56 -> 1234.56
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

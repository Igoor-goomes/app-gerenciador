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
            'preco'              => ['nullable', 'numeric', 'min:0'],
            'preco_unitario'     => ['nullable', 'numeric', 'min:0'],
            'preco_total'        => ['nullable', 'numeric', 'min:0'],
            'quantidade_estoque' => ['required', 'integer', 'min:0'],
            'categoria'          => ['nullable', 'array'],
            'categoria.*'        => ['string','max:100'],
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
            'preco_unitario'     => 'preço unitário',
            'preco_total'        => 'preço total',
            'quantidade_estoque' => 'quantidade em estoque',
            'categoria'          => 'categoria',
            'atributo'           => 'atributo'
        ];
    }

    protected function prepareForValidation(): void {
        $preco = $this->input('preco');
        $preco_unit = $this->input('preco_unitario');
        $qty = (float) $this->input('quantidade_estoque');
        // Normalize decimals if strings
        foreach (['preco','preco_unitario'] as $k) {
            $v = $this->input($k);
            if (is_string($v)) {
                $$k = str_replace(['.', ','], ['', '.'], preg_replace('/\s+/', '', $v));
            }
        }
        // Determine unit price preference: preco_unitario first, then preco
        $unit = $preco_unit !== null && $preco_unit !== '' ? $preco_unit : $preco;
        $total = $unit !== null && $unit !== '' ? (float)$unit * $qty : null;

        // Normalize atributo if sent as JSON string or key/value arrays turned into object
        $atributo = $this->input('atributo');
        if (is_string($atributo)) {
            $decoded = json_decode($atributo, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $atributo = $decoded;
            }
        }

        $this->merge([
            'nome'               => trim((string) $this->input('nome')),
            'descricao'          => $this->filled('descricao') ? trim((string) $this->input('descricao')) : null,
            'preco'              => $unit, // keep backward compat field name
            'preco_unitario'     => $unit,
            'preco_total'        => $total,
            'quantidade_estoque' => $this->input('quantidade_estoque'),
            'categoria'          => $this->input('categoria') ?? null,
            'atributo'           => $atributo ?? null,
        ]);
}
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Produto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Produto::class;

    public function definition(): array
    {
        return [
            'nome'               => $this->faker->words(2, true),
            'descricao'          => $this->faker->sentence(8),
            'preco'              => $this->faker->randomFloat(2, 10, 1000),
            'quantidade_estoque' => $this->faker->numberBetween(500),
            'categoria'          => [$this->faker->word(), $this->faker->word()],
            'atributo'           => [
                'marca'   => $this->faker->safeColorName(), 
                'tamanho' => $this->faker->randomElement(['P', 'M', 'G']), 
            ],
        ];
    }
}

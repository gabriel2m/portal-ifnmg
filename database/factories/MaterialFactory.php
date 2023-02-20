<?php

namespace Database\Factories;

use App\Models\Unidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->words(rand(1, 4), true),
            'descricao' => $this->faker->text(),
            'catmat' => $this->faker->numberBetween(1),
            'unidade_id' => $this->faker->randomElement(Unidade::pluck('id'))
        ];
    }
}

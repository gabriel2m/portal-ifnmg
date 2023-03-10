<?php

namespace Database\Factories;

use App\Enums\TipoMaterial;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
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
            'catmat' => $this->faker->numberBetween(1),
            'nome' => ucwords($this->faker->unique()->words(rand(1, 4), true)),
            'tipo' => $this->faker->randomElement(TipoMaterial::values()),
            'descricao' => $this->faker->text(),
            'unidade_id' => $this->faker->randomElement(Unidade::pluck('id'))
        ];
    }
}

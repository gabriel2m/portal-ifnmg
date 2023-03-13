<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\MaterialUnidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialCompra>
 */
class MaterialCompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'compra_id' => Compra::factory(),
            'material_unidade_id' => MaterialUnidade::factory(),
            'responsavel_valores' => $this->faker->name()
        ];
    }
}

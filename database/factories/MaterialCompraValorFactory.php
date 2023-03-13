<?php

namespace Database\Factories;

use App\Models\MaterialCompra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialCompraValor>
 */
class MaterialCompraValorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'material_compra_id' => MaterialCompra::factory(),
            'valor' => $this->faker->randomFloat(2, 1, 250)
        ];
    }
}

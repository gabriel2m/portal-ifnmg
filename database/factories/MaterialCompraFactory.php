<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\Material;
use App\Models\MaterialCompra;
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
        $compra_id = $this->faker->randomElement(Compra::pluck('id'));
        $ids = MaterialCompra::where('compra_id', $compra_id)->pluck('material_id');

        return [
            'compra_id' => $compra_id,
            'material_id' => $this->faker->randomElement(Material::whereNotIn('id', $ids)->pluck('id')),
            'valor' => $this->faker->randomFloat(2, 0.01, 999),
        ];
    }
}

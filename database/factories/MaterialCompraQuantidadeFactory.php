<?php

namespace Database\Factories;

use App\Models\MaterialCompra;
use App\Models\Setor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialCompraQuantidade>
 */
class MaterialCompraQuantidadeFactory extends Factory
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
            'setor_id' => Setor::factory(),
            'quantidade' => $this->faker->numberBetween(1, 99)
        ];
    }
}

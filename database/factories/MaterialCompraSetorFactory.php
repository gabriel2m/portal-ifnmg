<?php

namespace Database\Factories;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use App\Models\Setor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialCompraSetor>
 */
class MaterialCompraSetorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $material_compra_id = $this->faker->randomElement(MaterialCompra::pluck('id'));
        $ids = MaterialCompraSetor::where('material_compra_id', $material_compra_id)->pluck('setor_id');

        return [
            'material_compra_id' => $material_compra_id,
            'setor_id' => $this->faker->randomElement(Setor::whereNotIn('id', $ids)->pluck('id')),
            'quantidade' => $this->faker->numberBetween(1, 99)
        ];
    }
}

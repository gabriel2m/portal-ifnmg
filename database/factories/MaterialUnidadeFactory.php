<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaterialUnidade>
 */
class MaterialUnidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'material_id' => Material::factory(),
            'unidade_id' => Unidade::factory(),
        ];
    }
}

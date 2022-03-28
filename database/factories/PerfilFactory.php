<?php

namespace Database\Factories;

use App\Enums\Categorias;
use App\Models\Perfil;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerfilFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Perfil::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->text(40),
            'categoria' => $this->faker->randomElement(Categorias::valueList()),
            'descricao' => $this->faker->text(500),
        ];
    }
}

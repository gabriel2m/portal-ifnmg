<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SetorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->unique()->words(rand(1, 3), true)
        ];
    }
}

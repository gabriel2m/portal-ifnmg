<?php

namespace Database\Factories;

use App\Enums\NivelUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public static string $default_password = '12345678';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => null,
            'nivel' => $this->faker->randomElement(NivelUser::values()),
            'password' => '$2y$10$ajo57WG9RZ7N09FkdO9cTOp31bz1M36ZSh.ZpPAW.CESBwmvQkmDO', // 12345678 === $default_password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => now(),
            ];
        });
    }

    public function admin()
    {
        return $this->state(function () {
            return [
                'nivel' => NivelUser::Admin->value,
            ];
        });
    }

    public function tecnico()
    {
        return $this->state(function () {
            return [
                'nivel' => NivelUser::Tecnico->value,
            ];
        });
    }

    public function editor()
    {
        return $this->state(function () {
            return [
                'nivel' => NivelUser::Editor->value,
            ];
        });
    }
}

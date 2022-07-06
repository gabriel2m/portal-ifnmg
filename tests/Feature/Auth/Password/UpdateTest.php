<?php

namespace Tests\Feature\Auth\Password;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_post()
    {
        /** @var User */
        $user = User::factory()->create();

        $token = Password::broker()->{'createToken'}($user);

        $this
            ->post(route('password.update'), [
                'email' => $user->email,
                'token' => $token,
                'password' => $password = $this->faker->password(),
                'password_confirmation' => $password,
            ])
            ->assertRedirect();

        $this->assertCredentials(['name' => $user->name, 'password' => $password]);
    }
}

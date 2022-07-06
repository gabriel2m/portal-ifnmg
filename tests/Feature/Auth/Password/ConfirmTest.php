<?php

namespace Tests\Feature\Auth\Password;

use Database\Factories\UserFactory;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    public function test_post()
    {
        $response = $this
            ->actingAsRandom()
            ->post(route('password.confirm'), [
                'password' => UserFactory::$default_password,
            ])
            ->assertRedirect()
            ->assertSessionHas('auth.password_confirmed_at');
    }
}

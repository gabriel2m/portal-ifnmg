<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Factories\UserFactory;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('login'))
            ->assertOk();
    }

    public function test_post()
    {
        /** @var User */
        $user = User::factory()->create();

        $this
            ->post('login', [
                'name' => $user->name,
                'password' => UserFactory::$default_password
            ])
            ->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }
}

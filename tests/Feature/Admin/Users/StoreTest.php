<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $data = User::factory()->makeOne()->only([
            'name',
            'email',
            'nivel',
        ]);
        $data['nivel'] = $data['nivel']->value;
        $password = '12345678';

        $this
            ->actingAsAdmin()
            ->post(
                route('admin.users.store'),
                [
                    ...$data,
                    'password' => $password,
                    'password_confirmation' => $password,
                ]
            )
            ->assertRedirect();

        $this->assertDatabaseHas(User::class, $data);
        $this->assertDatabaseCount(User::class, 2);
    }
}

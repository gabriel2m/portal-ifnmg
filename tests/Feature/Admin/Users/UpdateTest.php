<?php

namespace Tests\Feature\Admin\Users;

use App\Models\Unidade;
use App\Models\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
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
            ->put(
                route('admin.users.update', User::factory()->create()),
                [
                    ...$data,
                    'password' => $password,
                    'password_confirmation' => $password,
                ]
            )
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(User::class, $data);
        $this->assertDatabaseCount(User::class, 2);
    }
}

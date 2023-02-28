<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $this
            ->actingAsAdmin()
            ->delete(route('admin.users.destroy', User::factory()->create()))
            ->assertRedirect();

        $this->assertDatabaseCount(User::class, 1);
    }
}

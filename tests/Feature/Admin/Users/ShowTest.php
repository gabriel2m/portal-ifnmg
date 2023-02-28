<?php

namespace Tests\Feature\Admin\Users;

use App\Models\User;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.users.show', User::factory()->create()))
            ->assertOk();
    }
}

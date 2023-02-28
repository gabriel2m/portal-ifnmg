<?php

namespace Tests\Feature\Admin\Users;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.users.create'))
            ->assertOk();
    }
}

<?php

namespace Tests\Feature\Auth\User;

use Tests\TestCase;

class PasswordTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get('user/password')
            ->assertOk();
    }
}

<?php

namespace Tests\Feature\Auth\User;

use Tests\TestCase;

class ConfirmPasswordTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get('user/confirm-password')
            ->assertOk();
    }
}

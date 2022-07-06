<?php

namespace Tests\Feature\Auth\Password;

use Tests\TestCase;

class ConfirmationTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('password.confirmation'))
            ->assertOk();
    }
}

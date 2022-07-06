<?php

namespace Tests\Feature\Auth\Password;

use Tests\TestCase;

class ResetTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('password.reset', 'token'))
            ->assertOk();
    }
}

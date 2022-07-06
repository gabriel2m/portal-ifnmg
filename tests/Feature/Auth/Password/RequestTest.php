<?php

namespace Tests\Feature\Auth\Password;

use Tests\TestCase;

class RequestTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('password.request'))
            ->assertOk();
    }
}

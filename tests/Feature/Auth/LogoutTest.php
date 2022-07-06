<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_post()
    {
        $this
            ->actingAsRandom()
            ->post(route('logout'))
            ->assertRedirect();

        $this->assertGuest();
    }
}

<?php

namespace Tests\Feature\Auth\User;

use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    public function test_get()
    {
        $this
            ->withSession(['auth.password_confirmed_at' => time()])
            ->actingAsRandom()
            ->get('user/profile-information')
            ->assertOk();
    }
}

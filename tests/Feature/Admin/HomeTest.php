<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.home'))
            ->assertOk();
    }
}

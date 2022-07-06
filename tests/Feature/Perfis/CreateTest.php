<?php

namespace Tests\Feature\Perfis;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('perfis.create'))
            ->assertOk();
    }
}

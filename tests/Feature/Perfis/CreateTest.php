<?php

namespace Tests\Feature\Perfis;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsEditor()
            ->get(route('perfis.create'))
            ->assertOk();
    }
}

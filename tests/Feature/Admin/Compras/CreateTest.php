<?php

namespace Tests\Feature\Admin\Compras;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.compras.create'))
            ->assertOk();
    }
}

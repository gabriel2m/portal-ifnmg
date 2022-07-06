<?php

namespace Tests\Feature\Admin\Itens;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.itens.create'))
            ->assertOk();
    }
}

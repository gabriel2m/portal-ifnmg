<?php

namespace Tests\Feature\Admin\Setores;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.setores.create'))
            ->assertOk();
    }
}

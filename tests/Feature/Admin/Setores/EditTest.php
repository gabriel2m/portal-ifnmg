<?php

namespace Tests\Feature\Admin\Setores;

use Tests\TestCase;

class UnidadesTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.setores.edit', 1))
            ->assertOk();
    }
}

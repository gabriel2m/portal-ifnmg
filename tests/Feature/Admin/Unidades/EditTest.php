<?php

namespace Tests\Feature\Admin\Unidades;

use Tests\TestCase;

class EditTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.unidades.edit', 1))
            ->assertOk();
    }
}

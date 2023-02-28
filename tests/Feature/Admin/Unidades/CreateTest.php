<?php

namespace Tests\Feature\Admin\Unidades;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.unidades.create'))
            ->assertOk();
    }
}

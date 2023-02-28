<?php

namespace Tests\Feature\Admin\Unidades;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.unidades.index'))
            ->assertOk();
    }
}

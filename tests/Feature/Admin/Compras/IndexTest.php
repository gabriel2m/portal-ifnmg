<?php

namespace Tests\Feature\Admin\Compras;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.compras.index'))
            ->assertOk();
    }
}

<?php

namespace Tests\Feature\Admin\Compras;

use App\Models\Compra;
use Tests\TestCase;

class EditTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.compras.edit', Compra::factory()->create()))
            ->assertOk();
    }
}

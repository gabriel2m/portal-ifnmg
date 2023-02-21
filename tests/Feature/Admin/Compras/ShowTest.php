<?php

namespace Tests\Feature\Admin\Compras;

use App\Models\Compra;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.compras.show', Compra::factory()->create()))
            ->assertOk();
    }
}

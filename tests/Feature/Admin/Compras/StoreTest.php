<?php

namespace Tests\Feature\Admin\Compras;

use App\Models\Compra;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $this
            ->actingAsAdmin()
            ->post(route('admin.compras.store'), $data = Compra::factory()->makeOne()->attributesToArray())
            ->assertRedirect();

        $this->assertDatabaseHas(Compra::class, $data);
    }
}

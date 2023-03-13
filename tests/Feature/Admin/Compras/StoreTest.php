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
            ->post(route('admin.compras.store'), $data = Compra::factory()->raw())
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(Compra::class, $data);
        $this->assertDatabaseCount(Compra::class, 1);
    }
}

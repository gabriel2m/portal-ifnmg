<?php

namespace Tests\Feature\Admin\Compras;

use App\Models\Compra;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $this
            ->actingAsAdmin()
            ->put(
                route('admin.compras.update', Compra::factory()->createOne()),
                $data = Compra::factory()->makeOne()->attributesToArray()
            )
            ->assertRedirect();

        $this->assertDatabaseHas(Compra::class, $data);
        $this->assertDatabaseCount(Compra::class, 1);
    }
}

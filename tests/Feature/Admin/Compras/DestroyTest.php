<?php

namespace Tests\Feature\Admin\Compras;

use App\Models\Compra;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $this
            ->actingAsAdmin()
            ->delete(route('admin.compras.destroy', Compra::factory()->create()))
            ->assertRedirect();

        $this->assertDatabaseEmpty(Compra::class);
    }
}

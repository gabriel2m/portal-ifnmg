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
            ->delete(route('admin.compras.destroy', $compra = Compra::factory()->createOne()))
            ->assertRedirect();

        $this->assertSoftDeleted($compra);
    }
}

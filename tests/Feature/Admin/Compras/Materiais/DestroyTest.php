<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\Compra;
use App\Models\Material;
use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $material = Material::factory()->createOne();
        $compra = Compra::factory()->createOne();
        MaterialCompra::factory()->create();
        MaterialCompraSetor::factory()->create();

        $this
            ->actingAsRandom()
            ->delete(route('admin.compras.materiais.destroy', [
                'compra' => $compra->ano,
                'material' => $material->catmat
            ]))
            ->assertRedirect();

        $this->assertDatabaseEmpty(MaterialCompra::class);
    }
}

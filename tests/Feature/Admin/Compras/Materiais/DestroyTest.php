<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $material_compra_setor = MaterialCompraSetor::factory()->create();

        $this
            ->actingAsAdmin()
            ->delete(route('admin.compras.materiais.destroy', [
                'compra' => $material_compra_setor->material_compra->compra->ano,
                'material' => $material_compra_setor->material_compra->material_unidade_id
            ]))
            ->assertRedirect();

        $this->assertDatabaseEmpty(MaterialCompra::class);
    }
}

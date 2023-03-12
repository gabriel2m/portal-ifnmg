<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraQuantidade;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $quantidade = MaterialCompraQuantidade::factory()->create();

        $this
            ->actingAsAdmin()
            ->delete(route('admin.compras.materiais.destroy', [
                'compra' => $quantidade->material_compra->compra->ano,
                'material' => $quantidade->material_compra->material_unidade_id
            ]))
            ->assertRedirect();

        $this->assertDatabaseEmpty(MaterialCompra::class);
    }
}

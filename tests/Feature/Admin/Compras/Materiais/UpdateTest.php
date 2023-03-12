<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraQuantidade;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $quantidade = MaterialCompraQuantidade::factory()->create();

        $material_compra_data = MaterialCompra::factory()->raw([
            'compra_id' => $quantidade->material_compra->compra,
        ]);

        $quantidade_data = MaterialCompraQuantidade::factory()->raw([
            'material_compra_id' => $quantidade->material_compra_id,
        ]);

        $this
            ->actingAsAdmin()
            ->put(
                route('admin.compras.materiais.update', [
                    'compra' => $quantidade->material_compra->compra->ano,
                    'material' => $quantidade->material_compra->material_unidade_id
                ]),
                [
                    ...$material_compra_data,
                    'quantidades' => [
                        $quantidade_data
                    ]
                ]
            )
            ->assertRedirect();

        $this->assertDatabaseHas(MaterialCompra::class, $material_compra_data);
        $this->assertDatabaseCount(MaterialCompra::class, 1);

        $quantidade_data['material_compra_id'] = $quantidade->material_compra_id;
        $this->assertDatabaseHas(MaterialCompraQuantidade::class, $quantidade_data);
        $this->assertDatabaseCount(MaterialCompraQuantidade::class, 1);
    }
}

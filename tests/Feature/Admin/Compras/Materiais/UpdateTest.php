<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraQuantidade;
use App\Models\MaterialCompraValor;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $quantidade = MaterialCompraQuantidade::factory()->create();
        $valor = MaterialCompraValor::factory()->create([
            'material_compra_id' => $quantidade->material_compra_id,
        ]);

        $material_compra_data = MaterialCompra::factory()->raw([
            'compra_id' => $quantidade->material_compra->compra,
        ]);

        $quantidade_data = MaterialCompraQuantidade::factory()->raw([
            'material_compra_id' => $quantidade->material_compra_id,
        ]);

        $valor_data = MaterialCompraValor::factory()->raw([
            'material_compra_id' => $valor->material_compra_id,
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
                    ],
                    'valores' => [
                        $valor_data
                    ]
                ]
            )
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(MaterialCompra::class, $material_compra_data);
        $this->assertDatabaseCount(MaterialCompra::class, 1);

        $quantidade_data['material_compra_id'] = $quantidade->material_compra_id;
        $this->assertDatabaseHas(MaterialCompraQuantidade::class, $quantidade_data);
        $this->assertDatabaseCount(MaterialCompraQuantidade::class, 1);

        $valor_data['material_compra_id'] = $valor->material_compra_id;
        $this->assertDatabaseHas(MaterialCompraValor::class, $valor_data);
        $this->assertDatabaseCount(MaterialCompraValor::class, 1);
    }
}

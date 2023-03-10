<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\Compra;
use App\Models\Material;
use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $material_compra_setor = MaterialCompraSetor::factory()->create();

        $material_compra_data = MaterialCompra::factory()->raw([
            'compra_id' => $material_compra_setor->material_compra->compra,
        ]);

        $material_compra_setor_data = MaterialCompraSetor::factory()->raw([
            'material_compra_id' => $material_compra_setor->material_compra_id,
        ]);

        $this
            ->actingAsAdmin()
            ->put(
                route('admin.compras.materiais.update', [
                    'compra' => $material_compra_setor->material_compra->compra->ano,
                    'material' => $material_compra_setor->material_compra->material_unidade_id
                ]),
                [
                    ...$material_compra_data,
                    'material_compra_setor' => [
                        $material_compra_setor_data
                    ]
                ]
            )
            ->assertRedirect();

        $this->assertDatabaseHas(MaterialCompra::class, $material_compra_data);
        $this->assertDatabaseCount(MaterialCompra::class, 1);

        $material_compra_setor_data['material_compra_id'] = $material_compra_setor->material_compra_id;
        $this->assertDatabaseHas(MaterialCompraSetor::class, $material_compra_setor_data);
        $this->assertDatabaseCount(MaterialCompraSetor::class, 1);
    }
}

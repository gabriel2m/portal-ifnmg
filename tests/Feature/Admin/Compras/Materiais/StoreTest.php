<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\Compra;
use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use App\Models\MaterialUnidade;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_put()
    {
        $material_unidade = MaterialUnidade::factory()->createOne();
        $compra = Compra::factory()->createOne();

        $material_compra_data = MaterialCompra::factory()->raw([
            'material_unidade_id' => $material_unidade,
            'compra_id' => $compra,
        ]);

        $material_compra_setor_data = MaterialCompraSetor::factory()->raw([
            'material_compra_id' => null,
        ]);

        $this
            ->actingAsAdmin()
            ->post(
                route('admin.compras.materiais.store', [
                    'compra' => $compra->ano
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

        $material_compra_setor_data['material_compra_id'] = 1;
        $this->assertDatabaseHas(MaterialCompraSetor::class, $material_compra_setor_data);
        $this->assertDatabaseCount(MaterialCompraSetor::class, 1);
    }
}

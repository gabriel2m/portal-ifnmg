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
        $material = Material::factory()->createOne();
        $compra = Compra::factory()->createOne();
        $material_compra = MaterialCompra::factory()->create();
        $material_compra_setor = MaterialCompraSetor::factory()->create();
        $material_novo = Material::factory()->createOne();

        $material_compra_data = [
            'material_id' => $material_novo->id,
            'valor' => 10,
        ];

        $material_compra_setor_data = [
            'setor_id' => $material_compra_setor->setor_id,
            'quantidade' => 10
        ];

        $this
            ->actingAsRandom()
            ->put(
                route('admin.compras.materiais.update', [
                    'compra' => $compra->ano,
                    'material' => $material->catmat
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

        $material_compra_setor_data['material_compra_id'] = $material_compra->id;
        $this->assertDatabaseHas(MaterialCompraSetor::class, $material_compra_setor_data);
        $this->assertDatabaseCount(MaterialCompraSetor::class, 1);
    }
}

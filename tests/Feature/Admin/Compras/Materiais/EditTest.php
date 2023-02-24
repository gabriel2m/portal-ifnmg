<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\Compra;
use App\Models\Material;
use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use Tests\TestCase;

class EditTest extends TestCase
{
    public function test_get()
    {
        $material = Material::factory()->createOne();
        $compra = Compra::factory()->createOne();
        MaterialCompra::factory()->create();
        MaterialCompraSetor::factory()->create();

        $this
            ->actingAsRandom()
            ->get(route('admin.compras.materiais.edit', [
                'compra' => $compra->ano,
                'material' => $material->catmat
            ]))
            ->assertOk();
    }
}

<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\MaterialCompraSetor;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $material_compra_setor = MaterialCompraSetor::factory()->create();
        
        $this
            ->actingAsAdmin()
            ->get(route('admin.compras.materiais.show', [
                'compra' => $material_compra_setor->material_compra->compra->ano,
                'material' => $material_compra_setor->material_compra->material_unidade_id
            ]))
            ->assertOk();
    }
}

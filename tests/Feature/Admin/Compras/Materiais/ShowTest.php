<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\MaterialCompraQuantidade;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $quantidade = MaterialCompraQuantidade::factory()->create();
        
        $this
            ->actingAsAdmin()
            ->get(route('admin.compras.materiais.show', [
                'compra' => $quantidade->material_compra->compra->ano,
                'material' => $quantidade->material_compra->material_unidade_id
            ]))
            ->assertOk();
    }
}

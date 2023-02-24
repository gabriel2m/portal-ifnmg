<?php

namespace Tests\Feature\Admin\Compras\Materiais;

use App\Models\Compra;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $compra = Compra::factory()->createOne();

        $this
            ->actingAsRandom()
            ->get(route('admin.compras.materiais.create', [
                'compra' => $compra->ano
            ]))
            ->assertOk();
    }
}

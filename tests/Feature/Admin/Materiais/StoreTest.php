<?php

namespace Tests\Feature\Admin\Materiais;

use App\Models\Material;
use App\Models\MaterialUnidade;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $material_data = Material::factory()->raw();

        $material_unidade_data = MaterialUnidade::factory()->raw([
            'material_id' => null
        ]);


        $this
            ->actingAsAdmin()
            ->post(route('admin.materiais.store'), [
                ...$material_data,
                'unidades' => [
                    $material_unidade_data
                ]
            ])
            ->assertRedirect();

        $this->assertDatabaseHas(Material::class, $material_data);
        $this->assertDatabaseCount(Material::class, 1);

        $material_unidade_data['material_id'] = 1;
        $this->assertDatabaseHas(MaterialUnidade::class, $material_unidade_data);
        $this->assertDatabaseCount(MaterialUnidade::class, 1);
    }
}

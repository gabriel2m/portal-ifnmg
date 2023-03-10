<?php

namespace Tests\Feature\Admin\Materiais;

use App\Models\Material;
use App\Models\MaterialUnidade;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $material_unidade = MaterialUnidade::factory()->create();

        $material_data = Material::factory()->raw();

        $material_unidade_data = MaterialUnidade::factory()->raw([
            'material_id' => $material_unidade->material
        ]);

        $this
            ->actingAsAdmin()
            ->put(route('admin.materiais.update', $material_unidade->material), [
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
        $this->assertSoftDeleted($material_unidade);
        $this->assertDatabaseCount(MaterialUnidade::class, 2);
    }
}

<?php

namespace Tests\Feature\Admin\Materiais;

use App\Models\Material;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $this
            ->actingAsAdmin()
            ->delete(route('admin.materiais.destroy', $material = Material::factory()->createOne()))
            ->assertRedirect();

        $this->assertDatabaseCount(Material::class, 1);
        $this->assertSoftDeleted($material);
    }
}

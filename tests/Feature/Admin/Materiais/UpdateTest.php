<?php

namespace Tests\Feature\Admin\Materiais;

use App\Models\Material;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $this
            ->actingAsRandom()
            ->put(
                route('admin.materiais.update', Material::factory()->createOne()),
                $data = Material::factory()->makeOne()->attributesToArray()
            )
            ->assertRedirect();

        $this->assertDatabaseHas(Material::class, $data);
        $this->assertDatabaseCount(Material::class, 1);
    }
}

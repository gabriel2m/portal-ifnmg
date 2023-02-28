<?php

namespace Tests\Feature\Admin\Materiais;

use App\Models\Material;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $this
            ->actingAsAdmin()
            ->post(route('admin.materiais.store'), $data = Material::factory()->raw())
            ->assertRedirect();

        $this->assertDatabaseHas(Material::class, $data);
        $this->assertDatabaseCount(Material::class, 1);
    }
}

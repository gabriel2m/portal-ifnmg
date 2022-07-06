<?php

namespace Tests\Feature\Admin\Materiais;

use App\Models\Material;
use Tests\TestCase;

class EditTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.materiais.edit', Material::factory()->create()))
            ->assertOk();
    }
}

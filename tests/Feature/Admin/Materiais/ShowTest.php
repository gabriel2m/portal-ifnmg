<?php

namespace Tests\Feature\Admin\Materiais;

use App\Models\Material;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.materiais.show', Material::factory()->create()))
            ->assertOk();
    }
}

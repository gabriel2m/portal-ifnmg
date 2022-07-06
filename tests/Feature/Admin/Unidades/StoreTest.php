<?php

namespace Tests\Feature\Admin\Unidades;

use App\Models\Unidade;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $this
            ->actingAsRandom()
            ->post(route('admin.unidades.store'), $data = Unidade::factory()->makeOne()->attributesToArray())
            ->assertRedirect();

        $this->assertDatabaseHas(Unidade::class, $data);
    }
}

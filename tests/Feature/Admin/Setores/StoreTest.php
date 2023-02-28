<?php

namespace Tests\Feature\Admin\Setores;

use App\Models\Setor;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $this
            ->actingAsAdmin()
            ->post(route('admin.setores.store'), $data = Setor::factory()->makeOne()->attributesToArray())
            ->assertRedirect();

        $this->assertDatabaseHas(Setor::class, $data);
    }
}

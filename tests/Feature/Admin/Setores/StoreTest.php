<?php

namespace Tests\Feature\Admin\Setores;

use App\Models\Setor;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $count = Setor::count();

        $this
            ->actingAsAdmin()
            ->post(route('admin.setores.store'), $data = Setor::factory()->raw())
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(Setor::class, $data);
        $this->assertDatabaseCount(Setor::class, $count + 1);
    }
}

<?php

namespace Tests\Feature\Admin\Unidades;

use App\Models\Unidade;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $count = Unidade::count();

        $this
            ->actingAsAdmin()
            ->post(route('admin.unidades.store'), $data = Unidade::factory()->raw())
            ->assertRedirect();

        $this->assertDatabaseHas(Unidade::class, $data);
        $this->assertDatabaseCount(Unidade::class, $count + 1);
    }
}

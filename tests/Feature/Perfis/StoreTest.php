<?php

namespace Tests\Feature\Perfis;

use App\Models\Perfil;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $this
            ->actingAsEditor()
            ->post(route('perfis.store'), $data = Perfil::factory()->raw())
            ->assertRedirect();

        $this->assertDatabaseHas(Perfil::class, $data);
        $this->assertDatabaseCount(Perfil::class, 1);
    }
}

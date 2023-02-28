<?php

namespace Tests\Feature\Perfis;

use App\Models\Perfil;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $this
            ->actingAsEditor()
            ->put(
                route('perfis.update', Perfil::factory()->createOne()),
                $data = Perfil::factory()->raw()
            )
            ->assertRedirect();

        $this->assertDatabaseHas(Perfil::class, $data);
        $this->assertDatabaseCount(Perfil::class, 1);
    }
}

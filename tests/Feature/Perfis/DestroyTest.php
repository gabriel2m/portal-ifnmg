<?php

namespace Tests\Feature\Perfis;

use App\Models\Perfil;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $this
            ->actingAsEditor()
            ->delete(route('perfis.destroy', $perfil = Perfil::factory()->create()))
            ->assertRedirect();

        $this->assertModelMissing($perfil);
    }
}

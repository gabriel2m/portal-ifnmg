<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_destroy_and_redirect_to_home_page()
    {
        /** @var Perfil */
        $perfil = Perfil::factory()->createOne();
        $response = $this
            ->delete(route('perfis.destroy', $perfil))
            ->assertRedirect(route('perfis.index'));

        $this->followRedirects($response)
            ->assertSee("Perfil \"$perfil->nome\" Deletado");

        $this->assertDatabaseCount(Perfil::class, 0);
    }
}

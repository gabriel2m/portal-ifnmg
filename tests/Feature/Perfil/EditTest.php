<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;

class EditTest extends GuardTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $perfil = Perfil::factory()->createOne();
        $this->route = route('perfis.edit', $perfil);
    }

    public function test_display_edit_page()
    {
        /** @var Perfil */
        $perfil = Perfil::first();
        $this
            ->get($this->route)
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>$perfil->nome | Editar | " . config('app.name') . "</title>",
                    'Editar Perfil',
                    'action="' . route('perfis.update', $perfil) . '"',
                    'PUT',
                    $perfil->nome,
                    $perfil->descricao,
                    'href="' . route('perfis.show', $perfil) . '"'
                ],
                escape: false
            );
    }
}

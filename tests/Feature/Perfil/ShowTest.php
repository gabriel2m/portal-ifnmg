<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_display_show_page()
    {
        /** @var Perfil */
        $perfil = Perfil::factory()->createOne();
        $this
            ->get(route('perfis.show', $perfil))
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>$perfil->nome | " . config('app.name') . "</title>",
                    $perfil->nome,
                    $perfil->descricao,
                    'action="' . route('perfis.destroy', $perfil) . '"',
                    'Desja realmente deletar esse perfil?',
                    'DELETE',
                    'Deletar',
                    'Editar',
                ],
                escape: false
            );
    }
}

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
            ->getOk(route('perfis.show', $perfil))
            ->assertSeeInOrder(
                values: [
                    "<title>$perfil->nome | " . config('app.name') . "</title>",
                    $perfil->nome,
                    $perfil->categorias_label,
                    $perfil->descricao,
                    'action="' . route('perfis.destroy', $perfil) . '"',
                    'Desja realmente deletar esse perfil?',
                    'DELETE',
                    'Deletar',
                    'href="' . route('perfis.edit', $perfil) . '"',
                    'Editar',
                ],
                escape: false
            );
    }
}

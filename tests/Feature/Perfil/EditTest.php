<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Tests\TestCase;

class EditTest extends TestCase
{
    public function test_display_edit_page()
    {
        /** @var Perfil */
        $perfil = Perfil::factory()->createOne();
        $this
            ->get(route('perfis.edit', $perfil))
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>$perfil->nome | Editar | " . config('app.name') . "</title>",
                    'Editar Perfil',
                    'action="' . route('perfis.update', $perfil) . '"',
                    'PUT',
                    'Nome',
                    'name="nome"',
                    $perfil->nome,
                    'Descrição',
                    'name="descricao"',
                    $perfil->descricao,
                    'Salvar',
                ],
                escape: false
            );
    }
}

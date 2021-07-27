<?php

namespace Tests\Feature\Perfil;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_display_create_page()
    {
        $this
            ->get(route('perfis.create'))
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>Novo Perfil | " . config('app.name') . "</title>",
                    'Novo Perfil',
                    'action="' . route('perfis.store') . '"',
                    'Nome',
                    'name="nome"',
                    'Descrição',
                    'name="descricao"',
                    'Salvar',
                ],
                escape: false
            );
    }
}

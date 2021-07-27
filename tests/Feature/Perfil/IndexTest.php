<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;

class IndexTest extends ListTestCase
{
    public function test_display_index_page()
    {
        $this
            ->get(route('perfis.index'))
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>Portfólio | " . config('app.name') . "</title>",
                    'action="' . route('perfis.search') . '"',
                    'GET',
                    'name="query"',
                    'name="avancada"',
                    'pesquisa avançada?',
                    'Portfólio',
                    ...$this->perfisList(Perfil::orderBy("nome")->get())
                ],
                escape: false
            );
    }
}

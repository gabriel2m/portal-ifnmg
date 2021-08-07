<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;

class IndexTest extends ListTestCase
{
    protected $route = 'perfis.index';

    protected function pageTitle()
    {
        return "Portfólio | " . config('app.name');
    }

    public function test_display_perfis_list()
    {
        $response = $this
            ->getOk(route($this->route))
            ->assertSeeInOrder(
                values: [
                    "<title>" . $this->pageTitle() . "</title>",
                    'action="' . route('perfis.search') . '"',
                    'GET',
                    'name="query"',
                    'name="avancada"',
                    'pesquisa avançada?',
                    'Portfólio',
                    'href="' . route($this->route, ['page' => 2]) . '"',
                ],
                escape: false
            );
        $this->assertCategoriasLinksList($response);
        $this->assertPerfisList($response, Perfil::orderBy("nome")->paginate()->items());
    }
}

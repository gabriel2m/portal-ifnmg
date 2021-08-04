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

    public function test_display_the_perfis_list()
    {
        $this
            ->get(route($this->route))
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>" . $this->pageTitle() . "</title>",
                    'action="' . route('perfis.search') . '"',
                    'GET',
                    'name="query"',
                    'name="avancada"',
                    'pesquisa avançada?',
                    'Portfólio',
                    ...$this->perfisList($results = Perfil::orderBy("nome")->paginate()->items()),
                    'href="' . route($this->route, ['page' => 2]) . '"',
                ],
                escape: false
            )
            ->assertDontSee(
                value: Perfil::whereNotIn(
                    'id',
                    array_column($results, 'id')
                )->pluck('nome'),
                escape: false
            );;
    }
}

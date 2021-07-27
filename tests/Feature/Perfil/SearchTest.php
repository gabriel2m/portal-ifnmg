<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;

class SearchTest extends ListTestCase
{
    /**
     * @param Perfil[] $results
     **/
    protected function assertSearch($query, $results)
    {
        return $this
            ->get(route('perfis.search', compact('query')))
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>&quot;$query&quot; | " . config('app.name') . "</title>",
                    'action="' . route('perfis.search') . '"',
                    'GET',
                    'name="query"',
                    $query,
                    'name="avancada"',
                    'pesquisa avançada?',
                    'Portfólio',
                    "Resultados para &quot;$query&quot;",
                ],
                escape: false
            )
            ->assertSee(
                value: $this->perfisList($results),
                escape: false
            )
            ->assertDontSee(
                value: $this->perfisList(
                    Perfil::whereNotIn(
                        'id',
                        array_column($results, 'id')
                    )->get()
                ),
                escape: false
            );
    }

    public function test_search()
    {
        $perfil1 = Perfil::factory()->createOne([
            'nome' => 'tijolo'
        ]);
        $perfil2 = Perfil::factory()->createOne([
            'descricao' => 'Tijolo'
        ]);
        $this->assertSearch(
            query: 'tijolo',
            results: [$perfil1, $perfil2]
        );
    }

    public function test_no_results_search()
    {
        $this->assertSearch(
            query: 'tijolo',
            results: []
        );
    }

    public function test_null_query_redirect_to_index()
    {
        $this
            ->get(route('perfis.search') . "?query=")
            ->assertRedirect(route('perfis.index'))
            ->assertSessionHasNoErrors();
    }

    public function test_query_max_255()
    {
        $this
            ->get(route('perfis.search', ['query' => str_repeat('a', 256)]))
            ->assertSessionHasErrors([
                'query' => __('validation.max.string', ['attribute' => 'query', 'max' => '255'])
            ]);
    }

    public function test_avancada_is_bool()
    {
        $this
            ->get(route('perfis.search', ['avancada' => 'tijolo']))
            ->assertSessionHasErrors([
                'avancada' => __('validation.boolean', ['attribute' => 'avancada'])
            ]);
    }
}

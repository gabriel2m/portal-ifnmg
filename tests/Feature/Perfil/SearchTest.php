<?php

namespace Tests\Feature\Perfil;

use App\Models\Categoria;
use App\Models\Perfil;

class SearchTest extends ListTestCase
{
    /**
     * @param Perfil[] $results
     **/
    protected function assertSearchByQuery($query, $results)
    {
        $response = $this
            ->getOk(route('perfis.search', compact('query')))
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
                    "Resultados para \"$query\"",
                ],
                escape: false
            );
        $this->assertCategoriasLinksList(...compact('response', 'query'));
        $this->assertPerfisList($response, $results);
        return $response;
    }

    public function test_search_by_query()
    {
        $results[] = Perfil::factory()->createOne([
            'nome' => 'Telha',
            'descricao' => 'tijolo'
        ]);
        $results[] = Perfil::factory()->createOne([
            'nome' => 'Tijolo'
        ]);
        $this->assertSearchByQuery(
            query: 'tijolo',
            results: $results
        );
    }

    public function test_search_by_categoria()
    {
        $categoria = Categoria::first();
        $route = route('perfis.search', $categoria);
        $response = $this
            ->getOk($route)
            ->assertSeeInOrder(
                values: [
                    "<title>$categoria->categoria | " . config('app.name') . "</title>",
                    "action=\"$route\"",
                ],
                escape: false
            );
        $this->assertCategoriasLinksList(response: $response, activeCategoria: $categoria->id);
        $this->assertPerfisList($response, $categoria->perfis()->paginate()->items());
    }

    public function test_search_by_query_and_categoria()
    {
        $categoria = Categoria::first();
        Perfil::factory()->createOne([
            'nome' => 'Tijolo'
        ]);
        foreach ([
            [
                'nome' => 'Telha',
                'descricao' => 'tijolo'
            ],
            [
                'nome' => 'Tijolo Dois'
            ],
        ] as $data)
            $results[] = Perfil::factory()
                ->hasAttached($categoria)
                ->createOne($data);
        $query = 'tijolo';
        $response = $this
            ->getOk(route('perfis.search', compact('query', 'categoria')))
            ->assertSeeInOrder(
                values: [
                    "<title>&quot;$query&quot; | $categoria->categoria | " . config('app.name') . "</title>",
                    'action="' . route('perfis.search', $categoria) . '"',
                    $query,
                    "Resultados para \"$query\"",
                ],
                escape: false
            );
        $this->assertCategoriasLinksList(response: $response, activeCategoria: $categoria->id, query: $query);
        $this->assertPerfisList($response, $results);
    }

    public function test_no_results_search()
    {
        $this->assertSearchByQuery(
            query: 'tijolo',
            results: []
        );
    }

    public function test_null_query_show_all()
    {
        $response = $this
            ->getOk(route('perfis.search') . "?query=")
            ->assertSeeInOrder(
                values: [
                    "<title>" . config('app.name') . "</title>",
                    'href="' . route('perfis.search', ['page' => 2]) . '"',
                ],
                escape: false
            )
            ->assertDontSee("Resultados para")
            ->assertSessionHasNoErrors();
        $this->assertPerfisList($response, Perfil::orderBy("nome")->paginate()->items());
    }

    public function test_pagination_links()
    {
        $query = 'a';
        $this
            ->getOk(route('perfis.search', compact('query')))
            ->assertSee(
                value: 'href="' . route('perfis.search') . '?query=a&amp;page=2"',
                escape: false
            );
    }

    public function test_avancada_is_bool()
    {
        $this
            ->get(route('perfis.search', ['avancada' => 'tijolo']))
            ->assertSessionHasErrors([
                'avancada' => __('validation.boolean', ['attribute' => 'avancada'])
            ]);
    }

    public function test_query_required_if_avancada_true()
    {
        $this
            ->get(route('perfis.search', ['avancada' => 1]))
            ->assertSessionHasErrors([
                'query' => __('validation.required', ['attribute' => 'query'])
            ]);
    }

    public function test_query_is_string()
    {
        $this
            ->get(route('perfis.search', ['query' => [1]]))
            ->assertSessionHasErrors([
                'query' => __('validation.string', ['attribute' => 'query'])
            ]);
    }

    public function test_query_max_255()
    {
        $this
            ->get(route('perfis.search', ['query' => str_repeat('a', 256)]))
            ->assertSessionHasErrors([
                'query' => __('validation.max.string', ['attribute' => 'query', 'max' => '255'])
            ]);
    }
}

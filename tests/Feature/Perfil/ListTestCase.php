<?php

namespace Tests\Feature\Perfil;

use App\Models\Categoria;
use App\Models\Perfil;
use Database\Seeders\PerfilSeeder;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ListTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PerfilSeeder::class);
    }

    protected function assertCategoriasLinksList(TestResponse $response, int $activeCategoria = null, $query = null)
    {
        foreach (Categoria::list() as $categoria) {
            $linksList[] = 'href="' . route(
                'perfis.search',
                ['categoria' => $categoria->id == $activeCategoria ? null : $categoria, 'query' => $query]
            ) . '"';
            $linksList[] = $categoria->categoria;
        }
        $response->assertSeeInOrder(values: $linksList, escape: false);
    }


    /**
     * @param Perfil[] $perfis
     */
    protected function assertPerfisList(TestResponse $response, $perfis)
    {
        foreach ($perfis as $perfil) {
            $perfisList[] = 'href="' . route('perfis.show', $perfil) . '"';
            $perfisList[] = e($perfil->nome);
            $perfisList[] = $perfil->categorias_label;
            $perfisList[] = $perfil->descricao;
        }
        $response
            ->assertSeeInOrder($perfisList ?? [], escape: false)
            ->assertDontSee(
                value: Perfil::whereNotIn(
                    'id',
                    array_column($perfis, 'id')
                )->pluck('nome'),
                escape: false
            );
    }
}

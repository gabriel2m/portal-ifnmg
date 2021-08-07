<?php

namespace Tests\Feature\Perfil;

use App\Models\Categoria;
use Tests\TestCase;

class GuardTestCase extends TestCase
{
    protected $route;

    public function test_see_guard_form()
    {
        $categoriasList = [];
        foreach (Categoria::list() as $categoria) {
            $categoriasList[] = 'name="categorias[]"';
            $categoriasList[] = "value=\"$categoria->id\"";
            $categoriasList[] = $categoria->categoria;
        }
        $this
            ->getOk($this->route)
            ->assertSeeInOrder(
                values: [
                    'for="nome"',
                    'Nome',
                    'name="nome"',
                    'Categorias',
                    ...$categoriasList,
                    'for="descricao"',
                    'Descrição',
                    'name="descricao"',
                    'Salvar',
                ],
                escape: false
            );
    }
}

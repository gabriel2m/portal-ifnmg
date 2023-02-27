<?php

namespace Tests\Feature\CategoriaPerfil;

use App\Enums\CategoriaPerfil;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('categorias.show', CategoriaPerfil::DesenvolvimentoProdutos->slug()))
            ->assertOk();
    }
}

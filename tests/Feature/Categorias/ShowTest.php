<?php

namespace Tests\Feature\Categorias;

use App\Enums\Categorias;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('categorias.show', Categorias::DESENVOLVIMENTO_DE_PRODUTOS->slug()))
            ->assertOk();
    }
}

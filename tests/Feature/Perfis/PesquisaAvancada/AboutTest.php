<?php

namespace Tests\Feature\Perfis\PesquisaAvancada;

use App\Models\Perfil;use Tests\TestCase;

class AboutTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('perfis.pesquisa-avancada.about'))
            ->assertOk();
    }
}

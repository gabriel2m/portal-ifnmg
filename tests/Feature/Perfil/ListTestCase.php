<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Tests\TestCase;

class ListTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Perfil::factory(10)->create();
    }

    /**
     * @param Perfil[] $perfis
     */
    public function perfisList($perfis)
    {
        $perfisList = [];
        foreach ($perfis as $perfil) {
            $perfisList[] = 'href="' . route('perfis.show', $perfil) . '"';
            $perfisList[] = $perfil->nome;
            $perfisList[] = $perfil->descricao;
        }
        return $perfisList;
    }
}

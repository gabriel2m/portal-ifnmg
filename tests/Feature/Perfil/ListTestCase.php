<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Database\Seeders\PerfilSeeder;
use Tests\TestCase;

class ListTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PerfilSeeder::class);
    }

    /**
     * @param Perfil[] $perfis
     */
    protected function perfisList($perfis)
    {
        $perfisList = [];
        foreach ($perfis as $perfil) {
            $perfisList[] = 'href="' . route('perfis.show', $perfil) . '"';
            $perfisList[] = $perfil->nome;
            $perfisList[] = $perfil->categorias_label;
            $perfisList[] = $perfil->descricao;
        }
        return $perfisList;
    }
}

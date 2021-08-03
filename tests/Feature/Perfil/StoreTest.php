<?php

namespace Tests\Feature\Perfil;

class StoreTest extends SaveTestCase
{
    protected $perfisCount = 0;

    protected function save($perfil = [], $categorias = [])
    {
        return $this->post(route('perfis.store'), parent::save($perfil, $categorias));
    }
}

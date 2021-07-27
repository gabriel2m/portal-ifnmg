<?php

namespace Tests\Feature\Perfil;

class StoreTest extends SaveTestCase
{
    protected $perfisCount = 0;

    protected function save(array $perfil)
    {
        return $this->post(route('perfis.store'), $perfil);
    }
}

<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;

class UpdateTest extends SaveTestCase
{
    protected $perfisCount = 1;

    protected function setUp(): void
    {
        parent::setUp();
        Perfil::factory()->createOne();
    }

    protected function save(array $perfil)
    {
        return $this->put(route('perfis.update', 1), $perfil);
    }
}

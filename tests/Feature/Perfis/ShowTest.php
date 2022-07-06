<?php

namespace Tests\Feature\Perfis;

use App\Models\Perfil;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('perfis.show', Perfil::factory()->create()))
            ->assertOk();
    }
}

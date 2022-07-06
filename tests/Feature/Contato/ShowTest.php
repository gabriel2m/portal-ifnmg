<?php

namespace Tests\Feature\Contato;

use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('contato.show'))
            ->assertOk();
    }
}

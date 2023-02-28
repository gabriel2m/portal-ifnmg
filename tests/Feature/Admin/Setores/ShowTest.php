<?php

namespace Tests\Feature\Admin\Setores;

use App\Models\Setor;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.setores.show', Setor::first()))
            ->assertOk();
    }
}

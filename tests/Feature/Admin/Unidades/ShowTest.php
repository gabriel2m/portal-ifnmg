<?php

namespace Tests\Feature\Admin\Unidades;

use App\Models\Unidade;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.unidades.show', Unidade::first()))
            ->assertOk();
    }
}

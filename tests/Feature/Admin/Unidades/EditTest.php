<?php

namespace Tests\Feature\Admin\Unidades;

use App\Models\Unidade;
use Tests\TestCase;

class EditTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.unidades.edit', Unidade::first()))
            ->assertOk();
    }
}

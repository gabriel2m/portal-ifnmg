<?php

namespace Tests\Feature\Admin\Setores;

use App\Models\Setor;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.setores.show', Setor::factory()->create()))
            ->assertOk();
    }
}

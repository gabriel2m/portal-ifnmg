<?php

namespace Tests\Feature\Admin\Setores;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.setores.index'))
            ->assertOk();
    }
}

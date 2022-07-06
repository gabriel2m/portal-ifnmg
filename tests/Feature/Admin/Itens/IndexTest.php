<?php

namespace Tests\Feature\Admin\Itens;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.itens.index'))
            ->assertOk();
    }
}

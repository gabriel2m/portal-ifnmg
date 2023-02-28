<?php

namespace Tests\Feature\Admin\Materiais;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsAdmin()
            ->get(route('admin.materiais.index'))
            ->assertOk();
    }
}

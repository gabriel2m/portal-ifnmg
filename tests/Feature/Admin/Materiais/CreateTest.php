<?php

namespace Tests\Feature\Admin\Materiais;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.materiais.create'))
            ->assertOk();
    }
}

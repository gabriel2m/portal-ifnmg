<?php

namespace Tests\Feature\Admin\Itens;

use App\Models\Item;
use Tests\TestCase;

class EditTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.itens.edit', Item::factory()->create()))
            ->assertOk();
    }
}

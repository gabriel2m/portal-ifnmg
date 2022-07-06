<?php

namespace Tests\Feature\Admin\Itens;

use App\Models\Item;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_get()
    {
        $this
            ->actingAsRandom()
            ->get(route('admin.itens.show', Item::factory()->create()))
            ->assertOk();
    }
}

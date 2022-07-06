<?php

namespace Tests\Feature\Admin\Itens;

use App\Models\Item;
use Tests\TestCase;

class StoreTest extends TestCase
{
    public function test_post()
    {
        $this
            ->actingAsRandom()
            ->post(route('admin.itens.store'), $data = Item::factory()->makeOne()->attributesToArray())
            ->assertRedirect();

        $this->assertDatabaseHas(Item::class, $data);
        $this->assertDatabaseCount(Item::class, 1);
    }
}

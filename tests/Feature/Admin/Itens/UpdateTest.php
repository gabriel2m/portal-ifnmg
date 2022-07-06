<?php

namespace Tests\Feature\Admin\Itens;

use App\Models\Item;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $this
            ->actingAsRandom()
            ->put(
                route('admin.itens.update', Item::factory()->createOne()),
                $data = Item::factory()->makeOne()->attributesToArray()
            )
            ->assertRedirect();

        $this->assertDatabaseHas(Item::class, $data);
        $this->assertDatabaseCount(Item::class, 1);
    }
}

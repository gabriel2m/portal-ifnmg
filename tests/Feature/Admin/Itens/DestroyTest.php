<?php

namespace Tests\Feature\Admin\Itens;

use App\Models\Item;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $this
            ->actingAsRandom()
            ->delete(route('admin.itens.destroy', $item = Item::factory()->createOne()))
            ->assertRedirect();

        $this->assertDatabaseCount(Item::class, 1);
        $this->assertSoftDeleted($item);
    }
}

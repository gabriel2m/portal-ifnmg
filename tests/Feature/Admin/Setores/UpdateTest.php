<?php

namespace Tests\Feature\Admin\Setores;

use App\Models\Setor;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $this
            ->actingAsRandom()
            ->put(
                route('admin.setores.update', Setor::factory()->createOne()),
                $data = Setor::factory()->makeOne()->attributesToArray()
            )
            ->assertRedirect();

        $this->assertDatabaseHas(Setor::class, $data);
    }
}

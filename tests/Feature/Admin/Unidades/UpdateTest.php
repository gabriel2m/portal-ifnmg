<?php

namespace Tests\Feature\Admin\Unidades;

use App\Models\Unidade;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $this
            ->actingAsAdmin()
            ->put(
                route('admin.unidades.update', Unidade::factory()->createOne()),
                $data = Unidade::factory()->makeOne()->attributesToArray()
            )
            ->assertRedirect();

        $this->assertDatabaseHas(Unidade::class, $data);
    }
}

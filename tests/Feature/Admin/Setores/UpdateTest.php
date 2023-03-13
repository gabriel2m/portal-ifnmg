<?php

namespace Tests\Feature\Admin\Setores;

use App\Models\Setor;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $count = Setor::count();

        $this
            ->actingAsAdmin()
            ->put(
                route('admin.setores.update', Setor::first()),
                $data = Setor::factory()->raw()
            )
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(Setor::class, $data);
        $this->assertDatabaseCount(Setor::class, $count);
    }
}

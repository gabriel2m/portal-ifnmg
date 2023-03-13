<?php

namespace Tests\Feature\Admin\Unidades;

use App\Models\Unidade;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_put()
    {
        $count = Unidade::count();

        $this
            ->actingAsAdmin()
            ->put(
                route('admin.unidades.update', Unidade::first()),
                $data = Unidade::factory()->raw()
            )
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(Unidade::class, $data);
        $this->assertDatabaseCount(Unidade::class, $count);
    }
}

<?php

namespace Tests\Feature\Admin\Unidades;

use App\Models\Unidade;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $this
            ->actingAsAdmin()
            ->delete(route('admin.unidades.destroy', $unidade = Unidade::first()))
            ->assertRedirect();

        $this->assertSoftDeleted($unidade);
    }
}

<?php

namespace Tests\Feature\Admin\Setores;

use App\Models\Setor;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_delete()
    {
        $this
            ->actingAsAdmin()
            ->delete(route('admin.setores.destroy', $setor = Setor::first()))
            ->assertRedirect();

        $this->assertSoftDeleted($setor);
    }
}

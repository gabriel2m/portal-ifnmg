<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Illuminate\Support\Str;

class UpdateTest extends SaveTestCase
{
    protected $perfisCount = 1;

    protected function setUp(): void
    {
        parent::setUp();
        Perfil::factory()->createOne();
    }

    protected function save(array $perfil)
    {
        return $this->put(route('perfis.update', 1), $perfil);
    }

    public function test_update_just_descricao()
    {
        $this->assertSave([
            'nome' => Perfil::find(1)->nome,
            'descricao' => Str::random(1000)
        ]);
    }
}

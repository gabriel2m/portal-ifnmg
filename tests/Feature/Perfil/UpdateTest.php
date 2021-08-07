<?php

namespace Tests\Feature\Perfil;

use App\Models\Categoria;
use App\Models\Perfil;
use Illuminate\Support\Str;

class UpdateTest extends SaveTestCase
{
    protected $perfisCount = 1;

    protected function setUp(): void
    {
        parent::setUp();
        Perfil::factory()->hasAttached(Categoria::whereNotIn('id', [5, 6])->get()->random(rand(1, 3)))->createOne();
    }

    protected function save($perfil = [], $categorias = [])
    {
        return $this->put(route('perfis.update', 1), parent::save($perfil, $categorias));
    }

    public function test_update_just_descricao()
    {
        $perfil = Perfil::first();
        $this->assertSave(
            perfil: [
                'nome' => $perfil->nome,
                'descricao' => Str::random(1000)
            ],
            categorias: $perfil->categorias->pluck('id')->toArray()
        );
    }
}

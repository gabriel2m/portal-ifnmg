<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = Categoria::pluck('id');
        foreach (range(1, 10) as $n) {
            $perfil = Perfil::factory()
                ->createOne();
            $perfilCategorias = $categorias->random(rand(1, 3))->toArray();
            if (in_array('5', $perfilCategorias))
                $perfilCategorias[] = 1;
            if (in_array('6', $perfilCategorias))
                $perfilCategorias = array_merge($perfilCategorias, [1, 5]);
            $perfil->categorias()->sync(array_unique($perfilCategorias));
        }
    }
}

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
        Perfil::truncate();
        $categorias = Categoria::all();
        foreach (range(1, 10) as $n)
            Perfil::factory()
                ->hasAttached($categorias->random(rand(1, 3)))
                ->createOne();
    }
}

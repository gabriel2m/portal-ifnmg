<?php

namespace Database\Seeders;

use App\Models\Perfil;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Perfil::imagemDisk()->deleteDirectory(config('app.perfil.imagem.dir'));
        Perfil::removeAllFromSearch();
        Perfil::query()->delete();
        $this->call([
            UserSeeder::class,
            PerfilSeeder::class,
            MaterialSeeder::class,
            CompraSeeder::class,
            MaterialCompraSeeder::class,
        ]);
    }
}

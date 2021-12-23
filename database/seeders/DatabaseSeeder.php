<?php

namespace Database\Seeders;

use App\Models\Perfil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk(config('app.perfil.imagem.disk'))->deleteDirectory(config('app.perfil.imagem.dir'));
        Perfil::removeAllFromSearch();
        $this->call([UserSeeder::class, PerfilSeeder::class]);
    }
}

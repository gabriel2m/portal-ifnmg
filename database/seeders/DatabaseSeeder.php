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
        Storage::disk(Perfil::IMAGEM_DISK)->deleteDirectory(Perfil::IMAGEM_DIR);
        if (Perfil::count())
            Perfil::removeAllFromSearch();
        $this->call([UserSeeder::class, PerfilSeeder::class]);
    }
}

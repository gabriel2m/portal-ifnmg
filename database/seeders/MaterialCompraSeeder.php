<?php

namespace Database\Seeders;

use App\Models\MaterialCompra;
use Illuminate\Database\Seeder;

class MaterialCompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 50) as $loop) { // Evita repetição de materiais
            MaterialCompra::factory()->create();
        }
    }
}

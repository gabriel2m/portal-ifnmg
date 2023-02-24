<?php

namespace Database\Seeders;

use App\Models\MaterialCompraSetor;
use Illuminate\Database\Seeder;

class MaterialCompraSetorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 500) as $loop) { // Evita repetição de materiais_compra
            MaterialCompraSetor::factory()->create();
        }
    }
}

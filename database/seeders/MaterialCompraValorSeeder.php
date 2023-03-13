<?php

namespace Database\Seeders;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraValor;
use Illuminate\Database\Seeder;

class MaterialCompraValorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (MaterialCompra::all() as $material_compra) {
            MaterialCompraValor::factory(rand(0, 5))->create([
                'material_compra_id' => $material_compra
            ]);
        }
    }
}

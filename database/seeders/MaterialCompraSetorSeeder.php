<?php

namespace Database\Seeders;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use App\Models\Setor;
use Illuminate\Database\Query\JoinClause;
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
        $setores = Setor::all();
        foreach (MaterialCompra::all() as $material_compra) {
            MaterialCompraSetor::factory(rand(1, $setores->count()))
                ->recycle($setores)
                ->create([
                    'material_compra_id' => $material_compra
                ]);
        }

        MaterialCompraSetor::query()
            ->getQuery()
            ->rightJoinSub(
                MaterialCompraSetor::query()
                    ->getQuery()
                    ->selectRaw('MIN(id) as id')
                    ->addSelect('material_compra_id', 'setor_id')
                    ->groupBy('material_compra_id', 'setor_id')
                    ->havingRaw('COUNT(*) > 1'),
                'duplicates',
                function (JoinClause $join) {
                    $join
                        ->on('materiais_compras_setores.material_compra_id', 'duplicates.material_compra_id')
                        ->on('materiais_compras_setores.setor_id', 'duplicates.setor_id');
                }
            )
            ->whereColumn('materiais_compras_setores.id', '!=', 'duplicates.id')
            ->delete();
    }
}

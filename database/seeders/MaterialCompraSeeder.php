<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\MaterialCompra;
use App\Models\MaterialUnidade;
use Illuminate\Database\Query\JoinClause;
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
        MaterialCompra::factory(100)
            ->recycle(Compra::all())
            ->recycle(MaterialUnidade::all())
            ->create();

        MaterialCompra::query()
            ->getQuery()
            ->rightJoinSub(
                MaterialCompra::query()
                    ->getQuery()
                    ->selectRaw('MIN(id) as id')
                    ->addSelect('material_unidade_id', 'compra_id')
                    ->groupBy('material_unidade_id', 'compra_id')
                    ->havingRaw('COUNT(*) > 1'),
                'duplicates',
                function (JoinClause $join) {
                    $join
                        ->on(MaterialCompra::columnName('material_unidade_id'), 'duplicates.material_unidade_id')
                        ->on(MaterialCompra::columnName('compra_id'), 'duplicates.compra_id');
                }
            )
            ->whereColumn(MaterialCompra::columnName('id'), '!=', 'duplicates.id')
            ->delete();
    }
}

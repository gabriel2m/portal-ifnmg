<?php

namespace Database\Seeders;

use App\Models\MaterialCompra;
use App\Models\MaterialCompraQuantidade;
use App\Models\Setor;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Seeder;

class MaterialCompraQuantidadeSeeder extends Seeder
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
            MaterialCompraQuantidade::factory(rand(1, $setores->count()))
                ->recycle($setores)
                ->create([
                    'material_compra_id' => $material_compra
                ]);
        }

        MaterialCompraQuantidade::query()
            ->getQuery()
            ->rightJoinSub(
                MaterialCompraQuantidade::query()
                    ->getQuery()
                    ->selectRaw('MIN(id) as id')
                    ->addSelect('material_compra_id', 'setor_id')
                    ->groupBy('material_compra_id', 'setor_id')
                    ->havingRaw('COUNT(*) > 1'),
                'duplicates',
                function (JoinClause $join) {
                    $join
                        ->on(MaterialCompraQuantidade::columnName('material_compra_id'), 'duplicates.material_compra_id')
                        ->on(MaterialCompraQuantidade::columnName('setor_id'), 'duplicates.setor_id');
                }
            )
            ->whereColumn(MaterialCompraQuantidade::columnName('id'), '!=', 'duplicates.id')
            ->delete();
    }
}

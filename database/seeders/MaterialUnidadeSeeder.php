<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\MaterialUnidade;
use App\Models\Unidade;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Seeder;

class MaterialUnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = Unidade::all();
        foreach (Material::all() as $material) {
            MaterialUnidade::factory(rand(1, min(3, $unidades->count())))
                ->recycle($unidades)
                ->create([
                    'material_id' => $material
                ]);
        }

        MaterialUnidade::query()
            ->rightJoinSub(
                MaterialUnidade::query()
                    ->getQuery()
                    ->selectRaw('MIN(id) as id')
                    ->addSelect('material_id', 'unidade_id')
                    ->groupBy('material_id', 'unidade_id')
                    ->havingRaw('COUNT(*) > 1'),
                'duplicates',
                function (JoinClause $join) {
                    $join
                        ->on('materiais_unidades.material_id', 'duplicates.material_id')
                        ->on('materiais_unidades.unidade_id', 'duplicates.unidade_id');
                }
            )
            ->whereColumn('materiais_unidades.id', '!=', 'duplicates.id')
            ->forceDelete();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Facades\DB;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveMaterialCompraRequest;
use App\Models\Compra;
use App\Models\Material;
use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
use App\Models\Setor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MaterialCompraController extends ResourceController
{
    protected string $name = 'admin.compras.materiais';

    protected string $model_class = MaterialCompra::class;

    /**
     * Return a datatables listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables(Compra $compra)
    {
        /** @var \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder */
        $query = MaterialCompra::query();

        $query->where('compra_id', $compra->id)
            ->join('materiais', 'materiais_compras.material_id', 'materiais.id')
            ->select(
                'materiais_compras.*',
                'materiais.catmat as catmat_material',
                'materiais.nome as nome_material',
            )->selectSub(
                MaterialCompraSetor::query()
                    ->getQuery()
                    ->whereColumn('material_compra_id', 'materiais_compras.id')
                    ->selectRaw("SUM(quantidade)"),
                "quantidade_total"
            )->selectSub(
                MaterialCompraSetor::query()
                    ->getQuery()
                    ->whereColumn('material_compra_id', 'materiais_compras.id')
                    ->selectRaw("SUM(quantidade)*materiais_compras.valor"),
                "valor_total"
            );

        foreach (Setor::pluck('id') as $setor_id) {
            $query->selectSub(
                MaterialCompraSetor::query()
                    ->getQuery()
                    ->whereColumn('material_compra_id', 'materiais_compras.id')
                    ->where('setor_id', $setor_id)
                    ->select("quantidade"),
                "quantidade_setor_$setor_id"
            );
        }

        return datatables($query)->toJson();
    }
}

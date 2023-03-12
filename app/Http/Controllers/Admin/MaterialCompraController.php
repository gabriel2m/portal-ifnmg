<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TipoMaterial;
use App\Facades\DB;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveMaterialCompraRequest;
use App\Models\Compra;
use App\Models\Material;
use App\Models\MaterialCompra;
use App\Models\MaterialCompraQuantidade;
use App\Models\MaterialUnidade;
use App\Models\Setor;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
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
    public function datatables(Request $request, Compra $compra)
    {
        extract($request->validate([
            'tipo' => [
                'required',
                Rule::enum(TipoMaterial::class)
            ]
        ]));

        /** @var \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder */
        $query = MaterialCompra::query();

        $query
            ->where(MaterialCompra::columnName('compra_id'), $compra->id)
            ->where(Material::columnName('tipo'), $tipo)
            ->join(MaterialUnidade::tableName(), MaterialCompra::columnName('material_unidade_id'), MaterialUnidade::columnName('id'))
            ->join(Material::tableName(), MaterialUnidade::columnName('material_id'), Material::columnName('id'))
            ->join(Unidade::tableName(), MaterialUnidade::columnName('unidade_id'), Unidade::columnName('id'))
            ->select(
                MaterialCompra::columnName('*'),
                Material::columnName('catmat as catmat_material'),
                Material::columnName('nome as nome_material'),
                Unidade::columnName('nome as unidade_material'),
            )->selectSub(
                MaterialCompraQuantidade::query()
                    ->getQuery()
                    ->whereColumn('material_compra_id', MaterialCompra::columnName('id'))
                    ->selectRaw("SUM(quantidade)"),
                "quantidade_total"
            );

        foreach (Setor::pluck('id') as $setor_id) {
            $query->selectSub(
                MaterialCompraQuantidade::query()
                    ->getQuery()
                    ->whereColumn('material_compra_id', MaterialCompra::columnName('id'))
                    ->where('setor_id', $setor_id)
                    ->select("quantidade"),
                "quantidade_setor_$setor_id"
            );
        }

        return datatables($query)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $compra)
    {
        abort_unless(
            $compra_id = Compra::where('ano', $compra)->value('id'),
            404
        );

        return $this->form(
            new MaterialCompra(compact('compra_id'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveCompraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveMaterialCompraRequest $request, int $compra)
    {
        abort_unless(
            $compra_id = Compra::where('ano', $compra)->value('id'),
            404
        );

        return $this->save(
            $request,
            new MaterialCompra(compact('compra_id'))
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $compra, int $material)
    {
        return $this->showAction(
            $this->getMaterialCompra($compra, $material)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $compra, int $material)
    {
        return $this->form(
            $this->getMaterialCompra($compra, $material)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SaveMaterialCompraRequest $request, int $compra, int $material)
    {
        return $this->save(
            $request,
            $this->getMaterialCompra($compra, $material)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $compra, int $material)
    {
        $material_compra = $this->getMaterialCompra($compra, $material);

        return $this->destroyAction(
            $material_compra,
            to_route('admin.compras.show', $material_compra->compra)
        );
    }

    /**
     * @param MaterialCompra $material_compra
     */
    protected function form(Model $material_compra, array $data = [])
    {
        $material_compra->fill(old());

        return view("$this->name.form", [
            ...$data,
            'material_compra' => $material_compra,
            'setores' => Setor::orderBy('nome')->pluck('nome', 'id'),
            'materiais_unidades' => MaterialUnidade::join(Material::tableName(), MaterialUnidade::columnName('material_id'), Material::columnName('id'))
                ->select(MaterialUnidade::columnName('*'))
                ->orderBy(Material::columnName('nome'))
                ->get()
                ->load('material', 'unidade'),
            'material_unidade' => MaterialUnidade::whereKey($material_compra->getOriginal('material_unidade_id'))->withTrashed()->first()
        ]);
    }

    /**
     * Save the specified resource in storage.
     * 
     * @param MaterialCompra $material_compra
     */
    protected function save(FormRequest $request, Model $material_compra)
    {
        Validator::make(
            $request->validated(),
            [
                'material_unidade_id' => [
                    Rule::unique(MaterialCompra::class)
                        ->where('compra_id', $material_compra->compra_id)
                        ->ignore($material_compra)
                ]
            ],
            [],
            ['material_unidade_id' => 'material']
        )->validate();

        return DB::transaction(function () use ($request, $material_compra) {
            if ($material_compra->fill($request->validated())->save()) {

                $material_compra->quantidades()->delete();
                $material_compra->quantidades()->createMany(
                    $request->validated('quantidades')
                );

                return to_route('admin.compras.materiais.show', [
                    'compra' => $material_compra->compra->ano,
                    'material' => $material_compra->material_unidade_id
                ])->with('flash', ['success' => 'Recurso Salvo.']);
            }
            return back()->with('flash', ['error' => 'Algo de errado ocorreu.']);
        });
    }

    protected function getMaterialCompra(int $compra, int $material_unidade_id): MaterialCompra
    {
        abort_unless(
            $compra_id = Compra::where('ano', $compra)->value('id'),
            404
        );

        return MaterialCompra::where(compact('compra_id', 'material_unidade_id'))->firstOrFail();
    }
}

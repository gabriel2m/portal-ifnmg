<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TipoMaterial;
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
            ->where('compra_id', $compra->id)
            ->where('materiais.tipo', $tipo)
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
            'materiais' => Material::orderBy('nome')->get(),
            'material' => Material::find($material_compra->getOriginal('material_id'))
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
                'material_id' => [
                    Rule::unique(MaterialCompra::class)
                        ->where('compra_id', $material_compra->compra->id)
                        ->ignore($material_compra)
                ]
            ],
            [],
            ['material_id' => 'material']
        )->validate();

        return DB::transaction(function () use ($request, $material_compra) {
            if ($material_compra->fill($request->validated())->save()) {

                $material_compra->material_compra_setores()->delete();
                $material_compra->material_compra_setores()->createMany(
                    $request->validated('material_compra_setor')
                );

                return to_route('admin.compras.materiais.show', [
                    'compra' => $material_compra->compra->ano,
                    'material' => $material_compra->material->catmat
                ])->with('flash', ['success' => 'Recurso Salvo.']);
            }
            return back()->with('flash', ['error' => 'Algo de errado ocorreu.']);
        });
    }

    protected function getMaterialCompra(int $compra, int $material): MaterialCompra
    {
        abort_unless(
            ($compra_id = Compra::where('ano', $compra)->value('id')) && ($material_id = Material::where('catmat', $material)->value('id')),
            404
        );

        return MaterialCompra::where(compact('compra_id', 'material_id'))->firstOrFail();
    }
}

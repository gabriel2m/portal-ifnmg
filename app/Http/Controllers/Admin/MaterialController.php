<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveMaterialRequest;
use App\Models\Material;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\Model;

class MaterialController extends ResourceController
{
    protected string $name = 'admin.materiais';

    protected string $parameter = 'material';

    protected string $afterSaveRoute = 'admin.materiais.show';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.materiais.index');
    }

    /**
     * Return a datatables listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        return datatables(Material::query())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Material);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveMaterialRequest $request)
    {
        return $this->save($request, new Material);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        return view('admin.materiais.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return $this->form($material);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveMaterialRequest  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(SaveMaterialRequest $request, Material $material)
    {
        return $this->save($request, $material);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        $response = to_route("{$this->name}.index");
        if ($material->delete())
            return $response->with('flash', ['warning' => "Material \"$material->nome\" Deletado"]);
        return $response->with('flash', ['error' => "Não foi possível deletar \"$material->nome\""]);
    }

    protected function form(Model $model, array $data = [])
    {
        $data['unidades'] = $this->unidades();
        return parent::form($model, $data);
    }

    protected function unidades()
    {
        return Unidade::orderBy('nome')->pluck('nome', 'id');
    }
}

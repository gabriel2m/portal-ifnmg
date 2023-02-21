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

    protected string $model_class = Material::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->indexAction();
    }

    /**
     * Return a datatables listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        return $this->datatablesAction();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->createAction();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveMaterialRequest $request)
    {
        return $this->storeAction($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        return $this->showAction($material);
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
        return $this->destroyAction($material);
    }

    protected function form(Model $material, array $data = [])
    {
        $data['unidades'] = Unidade::orderBy('nome')->pluck('nome', 'id');
        return parent::form($material, $data);
    }
}

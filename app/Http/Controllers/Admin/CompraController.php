<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveCompraRequest;
use App\Models\Compra;
use App\Models\Setor;

class CompraController extends ResourceController
{
    protected string $name = 'admin.compras';

    protected string $model_class = Compra::class;

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
     * @param  \App\Http\Requests\SaveCompraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCompraRequest $request)
    {
        return $this->storeAction($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        return $this->showAction($compra, [
            'setores' => Setor::orderBy('nome')->select('nome', 'id')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        return $this->form($compra);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveCompraRequest  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(SaveCompraRequest $request, Compra $compra)
    {
        return $this->save($request, $compra);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        return $this->destroyAction($compra);
    }
}

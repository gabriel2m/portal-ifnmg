<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveSetorRequest;
use App\Models\Setor;

class SetorController extends ResourceController
{
    protected string $name = 'admin.setores';

    protected string $model_class = Setor::class;

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
     * @param  \App\Http\Requests\SaveSetorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveSetorRequest $request)
    {
        return $this->storeAction($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function show(Setor $setor)
    {
        return $this->showAction($setor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function edit(Setor $setor)
    {
        return $this->form($setor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveSetorRequest  $request
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function update(SaveSetorRequest $request, Setor $setor)
    {
        return $this->save($request, $setor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setor $setor)
    {
        return $this->destroyAction($setor);
    }
}

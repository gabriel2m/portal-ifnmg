<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveCompraRequest;
use App\Models\Compra;

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
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        return $this->showAction($compra);
    }
}

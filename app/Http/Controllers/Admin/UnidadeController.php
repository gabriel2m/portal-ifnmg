<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveUnidadeRequest;
use App\Models\Unidade;

class UnidadeController extends ResourceController
{
    protected string $name = 'admin.unidades';

    protected string $parameter = 'unidade';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.unidades.index');
    }

    /**
     * Return a datatables listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        return datatables(Unidade::query())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Unidade);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveUnidadeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveUnidadeRequest $request)
    {
        return $this->save($request, new Unidade);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function show(Unidade $unidade)
    {
        return view('admin.unidades.show', compact('unidade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidade $unidade)
    {
        return $this->form($unidade);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveUnidadeRequest  $request
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(SaveUnidadeRequest $request, Unidade $unidade)
    {
        return $this->save($request, $unidade);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidade $unidade)
    {
        $response = to_route("{$this->name}.index");
        if ($unidade->delete())
            return $response->with('flash', ['warning' => "Unidade \"$unidade->nome\" Deletada"]);
        return $response->with('flash', ['error' => "Não foi possível deletar \"$unidade->nome\""]);
    }
}

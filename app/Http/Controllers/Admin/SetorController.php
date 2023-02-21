<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveSetorRequest;
use App\Models\Setor;

class SetorController extends ResourceController
{
    protected string $name = 'admin.setores';

    protected string $parameter = 'setor';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setores.index');
    }

    /**
     * Return a datatables listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatables()
    {
        return datatables(Setor::query())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Setor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveSetorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveSetorRequest $request)
    {
        return $this->save($request, new Setor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function show(Setor $setor)
    {
        return view('admin.setores.show', compact('setor'));
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
        $response = to_route("{$this->name}.index");
        if ($setor->delete())
            return $response->with('flash', ['warning' => "Setor \"$setor->nome\" Deletado"]);
        return $response->with('flash', ['error' => "Não foi possível deletar \"$setor->nome\""]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class ResourceController extends Controller
{
    protected string $name;

    protected string $parameter;

    protected string $afterSaveRoute;

    /**
     * Show the form for manipulate the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function form(Model $model, array $data = [])
    {
        return view("{$this->name}.form", [$this->parameter => $model, ...$data]);
    }

    /**
     * Save the specified resource in storage.
     */
    protected function save(FormRequest $request, Model $model)
    {
        if ($model->fill($request->validated())->save())
            return to_route(
                $this->afterSaveRoute ?? "{$this->name}.show",
                $model
            )->with('flash', ['success' => 'Tudo Salvo.']);
        return back()->with('flash', ['error' => 'Não foi possível salvar']);
    }
}

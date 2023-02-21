<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    protected string $name;

    protected string $model_class;

    public function modelName()
    {
        return Str::slug(class_basename($this->model_class), '_');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function indexAction()
    {
        return view("$this->name.index");
    }

    /**
     * Return a datatables listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function datatablesAction()
    {
        return datatables($this->model_class::query())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function createAction()
    {
        return $this->form(new $this->model_class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    protected function storeAction(FormRequest $request)
    {
        return $this->save($request, new $this->model_class);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function showAction(Model $model)
    {
        return view("$this->name.show", [$this->modelName() => $model]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyAction(Model $model)
    {
        $response = to_route("{$this->name}.index");
        if ($model->delete())
            return $response->with('flash', ['warning' => "Recurso Deletado"]);
        return $response->with('flash', ['error' => 'Algo de errado ocorreu.']);
    }

    /**
     * Show the form for manipulate the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function form(Model $model, array $data = [])
    {
        $model->fill(old());
        $data[$this->modelName()] = $model;
        return view("$this->name.form", $data);
    }

    /**
     * Save the specified resource in storage.
     */
    protected function save(FormRequest $request, Model $model)
    {
        if ($model->fill($request->validated())->save())
            return to_route("$this->name.show", $model)->with('flash', ['success' => 'Recurso Salvo.']);
        return back()->with('flash', ['error' => 'Algo de errado ocorreu.']);
    }
}

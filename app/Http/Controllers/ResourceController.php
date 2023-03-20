<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    protected string $name;

    protected string $model_class;

    public function modelName()
    {
        return Str::snake(class_basename($this->model_class));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function indexAction(array $data = [])
    {
        return view("$this->name.index", $data);
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
    protected function createAction(array $data = [])
    {
        return $this->form(new $this->model_class, $data);
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
    protected function showAction(Model $model, array $data = [])
    {
        $data[$this->modelName()] = $model;
        return view("$this->name.show", $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyAction(Model $model, RedirectResponse $success_route = null)
    {
        if ($model->delete())
            return ($success_route ?? to_route("{$this->name}.index"))->with('flash', ['warning' => "Recurso Deletado"]);
        return back()->with('flash', ['error' => 'Algo de errado ocorreu.']);
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
            return to_route("$this->name.show", $model)->with('flash', ['success' => 'Recurso salvo.']);
        return back()->with('flash', ['error' => 'Algo de errado ocorreu.']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\ResourceController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ResourceController
{
    protected string $name = 'admin.users';

    protected string $model_class = User::class;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = (new CreateNewUser)->create($request->all());

        if ($model->exists)
            return to_route("$this->name.show", $model)->with('flash', ['success' => 'Recurso Salvo.']);
        return back()->with('flash', ['error' => 'Algo de errado ocorreu.']);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showAction($user);
    }
}

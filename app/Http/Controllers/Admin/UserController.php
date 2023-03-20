<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UserValidationRules;
use App\Http\Controllers\ResourceController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ResourceController
{
    use UserValidationRules;

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
        $user = (new CreateNewUser)->create($request->all());

        if ($user->exists)
            return to_route("$this->name.show", $user)->with('flash', ['success' => 'Recurso salvo.']);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return $this->form($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        extract(
            $request->validate([
                'name' => $this->nameRules($user),
                'email' => $this->emailRules($user),
                'password' => $this->passwordRules(required: false),
                'nivel' => $this->nivelRules()
            ])
        );

        if (
            $user->forceFill(array_filter([
                'name' => $name,
                'email' => $email,
                'password' => isset($password) ? Hash::make($password) : false,
                'nivel' => $nivel
            ]))->save()
        )
            return to_route("$this->name.show", $user)->with('flash', ['success' => 'Recurso salvo.']);
        return back()->with('flash', ['error' => 'Algo de errado ocorreu.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return $this->destroyAction($user);
    }
}

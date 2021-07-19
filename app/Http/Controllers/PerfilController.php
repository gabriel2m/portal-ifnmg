<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perfis.create', ['perfil' => new Perfil]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->save($request, new Perfil);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Perfil $perfil)
    {
        return view('perfis.show', compact('perfil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        return view('perfis.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        return $this->save($request, $perfil);
    }

    /**
     * Store or Update the specified resource in storage.
     */
    protected function save(Request $request, Perfil $perfil)
    {
        $perfil->fill(
            $request->validate([
                'nome' => [
                    'bail',
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('perfis')->ignore($perfil)
                ],
                'descricao' => [
                    'bail',
                    'required',
                    'string',
                    'max:1000',
                ],
            ])
        )->save();

        return redirect()->route('perfis.show', ['perfil' => $perfil->id])->with('success', 'Perfil Salvo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {

        if ($perfil->delete())
            return redirect('/')->with('warning', "Perfil \"$perfil->nome\" Deletado");
        return redirect()->route('perfis.show', ['perfil' => $perfil->id])->with('warning', 'Não foi possiveldeletar esse perfil');
    }
}

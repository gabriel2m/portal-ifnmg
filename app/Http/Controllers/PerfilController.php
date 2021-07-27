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
    public function index(Request $request)
    {
        return view('perfis.index', [
            'perfis' => Perfil::orderBy('nome')->get(),
            'pageTitle' => $request->route()->getName() === 'perfis.index' ? 'Portfólio' : null
        ]);
    }

    /**
     * Execute a search and display the listing of results.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        extract($request->validate([
            'query' => [
                'bail',
                'nullable',
                'string',
                'max:255',
            ],
            'avancada' => [
                'bail',
                'bool',
            ],
        ]));
        if (!isset($query))
            return redirect()->route('perfis.index');
        $avancada ??= false;
        $perfis = $avancada
            ? Perfil::rawSearch()->query(['simple_query_string' => ["query" => $query]])->{'execute'}()->{'models'}()
            : Perfil::where('nome', 'like', "%$query%")->orWhere('descricao', 'like', "%$query%")->orderBy('nome')->get();
        return view('perfis.search', compact('perfis', 'query', 'avancada'));
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

        return redirect()->route('perfis.show', $perfil)->with('success', 'Perfil Salvo');
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
            return redirect()->route('perfis.index')->with('warning', "Perfil \"$perfil->nome\" Deletado");
        return redirect()->route('perfis.show', $perfil)->with('warning', 'Não foi possivel deletar esse perfil');
    }
}

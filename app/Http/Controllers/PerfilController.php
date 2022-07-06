<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePerfilRequest;
use App\Enums\Categorias;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PerfilController extends ResourceController
{
    protected string $name = 'perfis';

    protected string $parameter = 'perfil';

    public function __construct()
    {
        $this->middleware('auth')->except(['advancedSearch', 'show']);
    }

    /**
     * Execute a search and display the listing of results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function advancedSearch(Request $request)
    {
        $categoria = Categorias::DESENVOLVIMENTO_DE_PRODUTOS->value;

        extract($request->validate([
            'query' => [
                'required',
                'string',
                'max:255',
            ],
            'categoria' => [
                new Enum(Categorias::class)
            ],
        ]));

        $perfis = Perfil::rawSearch()
            ->query(['simple_query_string' => ["query" => $query]])
            ->{'postFilter'}('term', ['categoria' => $categoria])
            ->paginate(Perfil::PER_PAGE)->withQueryString();

        $categoria = Categorias::from($categoria);

        return view('perfis.pesquisa-avancada.show', compact('perfis', 'query', 'categoria'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Perfil);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SavePerfilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SavePerfilRequest $request)
    {
        return $this->save($request, new Perfil);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
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
        return $this->form($perfil);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SavePerfilRequest  $request
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(SavePerfilRequest $request, Perfil $perfil)
    {
        return $this->save($request, $perfil);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        if ($perfil->delete())
            return redirect()->route('home')->with('warning', "Perfil \"$perfil->nome\" Deletado");
        return redirect()->route("{$this->name}.show", $perfil)->with('danger', 'Não foi possível deletar esse perfil');
    }
}

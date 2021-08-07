<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePerfilRequest;
use App\Models\Categoria;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'perfis' => Perfil::orderBy('nome')->paginate(),
            'pageTitle' => $request->routeIs('perfis.index') ? ['Portfólio'] : null
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

        if ($avancada ??= false) {
            $perfis = Perfil::rawSearch()->query(['simple_query_string' => ["query" => $query]]);
        } else
            $perfis = Perfil::where('nome', 'like', "%$query%")->orWhere('descricao', 'like', "%$query%")->orderBy('nome');
        $perfis = $perfis->paginate();
        return view('perfis.search', compact('perfis', 'query', 'avancada'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->guard(view: 'perfis.create', perfil: new Perfil);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePerfilRequest $request)
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
        return $this->guard(view: 'perfis.edit', perfil: $perfil);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePerfilRequest $request, Perfil $perfil)
    {
        return $this->save($request, $perfil);
    }

    /**
     * Show the form for manipulate a perfil.
     *
     * @return \Illuminate\Http\Response
     */
    protected function guard($view, Perfil $perfil)
    {
        return view($view, ['perfil' => $perfil, 'categorias' => Categoria::list()]);
    }

    /**
     * Store or Update the specified resource in storage.
     */
    protected function save(SavePerfilRequest $request, Perfil $perfil)
    {
        $perfilData = $request->validated();
        $categorias = $perfilData['categorias'];
        unset($perfilData['categorias']);
        $perfil->fill($perfilData);
        if (DB::transaction(function () use ($perfil, $categorias) {
            if (!$perfil->save())
                return false;
            $perfil->categorias()->sync($categorias);
            return true;
        }) === true)
            return redirect()->route('perfis.show', $perfil)->with('success', 'Perfil Salvo');
        return back()->with('warning', 'Não foi possivel salvar esse Perfil');
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

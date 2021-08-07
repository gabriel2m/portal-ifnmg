<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePerfilRequest;
use App\Models\Categoria;
use App\Models\Perfil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'perfis' => Perfil::orderBy('nome')->paginate(),
            'categorias' => Categoria::list(),
            'pageTitle' => $request->routeIs('perfis.index') ? ['Portfólio'] : null
        ]);
    }

    /**
     * Execute a search and display the listing of results.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, Categoria $categoria = null)
    {
        $query = $avancada = null;
        extract($request->validate([
            'avancada' => 'bool'
        ]));
        extract($request->validate([
            'query' => [
                Rule::requiredIf($avancada == true),
                'nullable',
                'string',
                'max:255',
            ],
        ]));

        if ($avancada) {
            $perfis = Perfil::rawSearch()->query(['simple_query_string' => ["query" => $query]]);
            if (isset($categoria))
                $perfis->{'postFilter'}('term', ['categorias' => $categoria->id]);
        } else {
            $perfis = isset($categoria) ? $categoria->perfis() : Perfil::orderBy('nome');
            if (isset($query))
                $perfis->where(function (Builder $builder) use ($query) {
                    $builder
                        ->where('nome', 'like', "%$query%")
                        ->orWhere('descricao', 'like', "%$query%");
                });
        }
        $perfis = $perfis->paginate()->withQueryString();
        return view('perfis.search', array_merge(
            compact('perfis', 'query', 'avancada'),
            ['categorias' => Categoria::list(), 'activeCategoria' => $categoria]
        ));
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
            if (in_array('5', $categorias))
                $categorias[] = 1;
            if (in_array('6', $categorias))
                $categorias = array_merge($categorias, [1, 5]);
            $perfil->categorias()->sync(array_unique($categorias));
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

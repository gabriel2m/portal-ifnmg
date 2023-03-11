<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePerfilRequest;
use App\Enums\CategoriaPerfil;
use App\Http\Middleware\NivelAdminEditor;
use App\Models\Perfil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PerfilController extends ResourceController
{
    protected string $name = 'perfis';

    protected string $model_class = Perfil::class;

    public function __construct()
    {
        $this->middleware([
            'auth',
            NivelAdminEditor::class
        ])->except(['advancedSearch', 'show']);
    }

    /**
     * Execute a search and display the listing of results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function advancedSearch(Request $request)
    {
        $categoria = CategoriaPerfil::DesenvolvimentoProdutos->value;

        extract($request->validate([
            'query' => [
                'required',
                'string',
                'max:255',
            ],
            'categoria' => [
                new Enum(CategoriaPerfil::class)
            ],
        ]));

        $perfis = Perfil::rawSearch()
            ->query(['simple_query_string' => ["query" => $query]])
            ->{'postFilter'}('term', ['categoria' => $categoria])
            ->paginate(Perfil::PER_PAGE)->withQueryString();

        $categoria = CategoriaPerfil::from($categoria);

        return view('perfis.pesquisa-avancada.show', compact('perfis', 'query', 'categoria'));
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
     * @param  \App\Http\Requests\SavePerfilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SavePerfilRequest $request)
    {
        return $this->storeAction($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        return $this->showAction($perfil);
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
            return to_route('portal.home')->with('warning', "Perfil \"$perfil->nome\" Deletado");
        return to_route("{$this->name}.show", $perfil)->with('danger', 'Não foi possível deletar esse perfil');
    }

    protected function save(FormRequest $request, Model $model)
    {
        if ($model->fill($request->validated())->save())
            return to_route("{$this->name}.show", $model)->with('success', 'Perfil Salvo.');
        return back()->with('warning', 'Não foi possível salvar');
    }
}

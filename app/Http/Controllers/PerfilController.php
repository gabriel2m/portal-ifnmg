<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePerfilRequest;
use App\Enums\Categorias;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use RuntimeException;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['advancedSearch', 'show']);
    }

    /**
     * Execute a search and display the listing of results.
     *
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
        return $this->keep(new Perfil);
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
        return $this->keep($perfil);
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
    protected function keep(Perfil $perfil)
    {
        return view('perfis.keep', compact('perfil'));
    }

    /**
     * Store or Update the specified resource in storage.
     */
    protected function save(SavePerfilRequest $request, Perfil $perfil)
    {
        $oldImg = $perfil->imagem;
        $perfil->fill($request->validated());
        $saveImg = $perfil->imagem !== $oldImg;
        throw_if(
            $saveImg && !tap(
                $request->file('imagem')->storePublicly(
                    config('app.perfil.imagem.dir'),
                    config('app.perfil.imagem.disk')
                ),
                function ($stored) use ($perfil) {
                    $perfil->imagem = $stored;
                }
            ),
            new RuntimeException("Não foi possível salvar Perfil->imagem")
        );
        if ($perfil->save()) {
            if (
                isset($oldImg)
                && $saveImg
                && !Storage::disk(config('app.perfil.imagem.disk'))->delete($oldImg)
            )
                throw new RuntimeException("Não foi possível deletar $oldImg");
            return redirect()->route('perfis.show', $perfil)->with('success', 'Perfil Salvo');
        }
        return back()->with('warning', 'Não foi possível salvar');
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
            return redirect()->route('home')->with('warning', "Perfil \"$perfil->nome\" Deletado");
        return redirect()->route('perfis.show', $perfil)->with('warning', 'Não foi possível deletar esse perfil');
    }
}

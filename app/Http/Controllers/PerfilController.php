<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePerfilRequest;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
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
        $categoria = Perfil::CATEGORIA_PESQUISADORES;

        extract($request->validate([
            'query' => [
                'required',
                'string',
                'max:255',
            ],
            'categoria' => [
                Rule::in(Perfil::categorias())
            ],
        ]));

        $perfis = Perfil::rawSearch()
            ->query(['simple_query_string' => ["query" => $query]])
            ->{'postFilter'}('term', ['categoria' => $categoria])
            ->paginate(Perfil::PER_PAGE)->withQueryString();

        return view('perfis.advanced-search', compact('perfis', 'query', 'categoria'));
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
        if ($saveImg = $perfil->imagem !== $oldImg
            && !($perfil->imagem = $request->file('imagem')->store(Perfil::IMAGEM_DIR, Perfil::IMAGEM_DISK)
                && $perfil->imagem = Storage::url($perfil->imagem))
        )
            throw new RuntimeException("Não foi possível salvar Perfil->imagem");
        if ($perfil->save()) {
            if (
                isset($oldImg) &&
                $saveImg &&
                $oldImg !== Perfil::IMAGEM_DEFAULT &&
                !Storage::disk(Perfil::IMAGEM_DISK)->delete(Perfil::IMAGEM_DIR . '/' . Str::of($oldImg)->basename())
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
            return redirect()->route('portfolio')->with('warning', "Perfil \"$perfil->nome\" Deletado");
        return redirect()->route('perfis.show', $perfil)->with('warning', 'Não foi possível deletar esse perfil');
    }
}

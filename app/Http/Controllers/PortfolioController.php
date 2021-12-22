<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        return view('portfolio.index');
    }

    public function prestacaoServicos(Request $request)
    {
        $categoria = Perfil::CATEGORIA_PESQUISADORES;
        $categorias = [Perfil::CATEGORIA_PESQUISADORES, Perfil::CATEGORIA_LABORATORIOS];
        extract($request->validate([
            'categoria' => [
                Rule::in($categorias)
            ],
        ]));

        return $this->page(
            $request,
            $categoria,
            titulo: 'Prestação de Serviços',
            descricao: 'TODO: Descrição.
        Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
        sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
        sequi deleniti. Dolor dignissimos officia rerum dolorem.',
            categorias: $categorias
        );
    }

    public function empresasJunior(Request $request)
    {
        return $this->page(
            $request,
            categoria: Perfil::CATEGORIA_EMPRESAS_JUNIOR,
            descricao: 'TODO: Descrição.
        Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
        sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
        sequi deleniti. Dolor dignissimos officia rerum dolorem.'
        );
    }

    public function incubadoraTecnologica(Request $request)
    {
        return $this->page(
            $request,
            categoria: Perfil::CATEGORIA_INCUBADORA_TECNOLOGICA,
            descricao: 'TODO: Descrição.
        Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
        sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
        sequi deleniti. Dolor dignissimos officia rerum dolorem.'
        );
    }

    public function instituicoesParceiras(Request $request)
    {
        return $this->page(
            $request,
            categoria: Perfil::CATEGORIA_INSTITUICOES_PARCEIRAS,
            descricao: 'TODO: Descrição.
        Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
        sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
        sequi deleniti. Dolor dignissimos officia rerum dolorem.'
        );
    }

    protected function page(Request $request, $categoria, $titulo = null, $descricao = null, $categorias = null)
    {
        $titulo ??= Perfil::LABELS_CATEGORIAS[$categoria];

        $filtro = null;
        extract($request->validate([
            'filtro' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]));

        $perfis = Perfil::orderBy('nome')->where('categoria', $categoria);
        if (isset($filtro))
            $perfis->where(function (Builder $builder) use ($filtro) {
                $builder
                    ->where('nome', 'like', "%$filtro%")
                    ->orWhere('descricao', 'like', "%$filtro%");
            });
        $perfis = $perfis->paginate()->withQueryString();

        return view('portfolio.page', compact('perfis', 'filtro', 'titulo', 'categoria', 'descricao', 'categorias'));
    }
}

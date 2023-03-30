<?php

namespace App\Http\Controllers;

use App\Enums\CategoriaPerfil;
use App\Models\Perfil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function show(Request $request, string $slug)
    {
        foreach (CategoriaPerfil::cases() as $case)
            if ($case->slug() == $slug)
                $categoria = $case;

        abort_unless(isset($categoria), 404);

        extract($request->validate([
            'filtro' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]));

        $perfis = Perfil::orderBy('nome')->where('categoria', $categoria);
        if ($filtro ??= null)
            $perfis->where(function (Builder $builder) use ($filtro) {
                $builder
                    ->where('nome', 'like', "%$filtro%")
                    ->orWhere('descricao', 'like', "%$filtro%");
            });
        $perfis = $perfis->paginate()->withQueryString();

        return view('categorias.show', compact('categoria', 'perfis', 'filtro'));
    }
}

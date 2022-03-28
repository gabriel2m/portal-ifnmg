<?php

use App\Enums\Categorias;
use App\Http\Controllers\PerfilController;
use App\Models\Perfil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function () {
    $perfis = [];
    foreach (Categorias::cases() as $categoria)
        $perfis[$categoria->name] = Perfil::orderBy('nome')->where('categoria', $categoria)->get();
    return view('home', compact('perfis'));
})->name('home');

Route::get("categorias/{slug}", function (Request $request, string $slug) {
    foreach (Categorias::cases() as $case)
        if ($case->slug() == $slug)
            $categoria = $case;

    if (!isset($categoria))
        return abort(404);

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

    return view('categorias.show', compact('categoria', 'perfis', 'filtro'));
})->name("categorias.show");

Route::name('perfis.advanced-search')
    ->prefix('pesquisa-avancada')
    ->group(function () {
        Route::get('', PerfilController::class . '@advancedSearch');
        Route::get('sobre', function (Request $request) {
            return '
                TODO: Página explicando a pesquisa avançada. 
                Baseada em: 
                <a href="https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html">
                    https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
                </a>
            ';
        })->name('.about');
    });

Route::resource('perfis', PerfilController::class)
    ->parameters(['perfis' => 'perfil'])
    ->except('index');

Route::get('contato', function (Request $request) {
    return 'TODO: Página de contato.';
})->name('contact');

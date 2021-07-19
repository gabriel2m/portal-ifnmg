<?php

use App\Http\Controllers\PerfilController;
use App\Models\Perfil;
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

Route::get('/', function (Request $request) {
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
    $avancada ??= false;
    $query ??= null;

    if (isset($query))
        $perfis = $avancada
            ? Perfil::rawSearch()->query(['simple_query_string' => ["query" => $query]])->{'execute'}()->{'models'}()
            : Perfil::where('nome', 'like', "%$query%")->orWhere('descricao', 'like', "%$query%")->orderBy('nome')->get();
    else
        $perfis = Perfil::orderBy('nome')->get();

    return view('home', compact('perfis', 'query', 'avancada'));
})->name('home');

Route::get('pesquisa-avancada', function (Request $request) {
    return 'TODO: Página explicando a pesquisa avançada. 
    Baseada em: 
    <a href="https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html">
    https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
    </a>';
})->name('pesquisa-avancada');

Route::resource('perfis', PerfilController::class)->parameters([
    'perfis' => 'perfil'
]);

<?php

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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

Route::get('', [PortfolioController::class, 'index'])->name('home');
Route::name('portfolio.')
    ->prefix('portfolio')
    ->group(function () {
        foreach (['prestacao-servicos', 'empresas-junior', 'incubadora-tecnologica', 'instituicoes-parceiras'] as $uri)
            Route::get($uri, [PortfolioController::class, Str::camel($uri)])->name($uri);
    });

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

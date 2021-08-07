<?php

use App\Http\Controllers\PerfilController;
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

Route::get('/perfis/search/{categoria?}', PerfilController::class . '@search')->name('perfis.search');
Route::resource('perfis', PerfilController::class)->parameters([
    'perfis' => 'perfil'
]);
Route::get('/', PerfilController::class . '@index')->name('home');

Route::get('pesquisa-avancada', function (Request $request) {
    return '
        TODO: Página explicando a pesquisa avançada. 
        Baseada em: 
        <a href="https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html">
            https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
        </a>
    ';
})->name('pesquisa-avancada');
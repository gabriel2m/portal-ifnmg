<?php

use App\Enums\UserPermission;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\MaterialCompraController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\SetorController;
use App\Http\Controllers\Admin\UnidadeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\PerfilController;
use App\Http\Middleware\AdminPermission;
use App\Http\Middleware\TecnicoPermission;
use Illuminate\Support\Facades\Route;

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

Route::view('', 'home')->name('portal.home');

Route::get("categorias/{slug}", [CategoriaController::class, 'show'])->name("categorias.show");

Route::name('perfis.pesquisa-avancada.')
    ->prefix('pesquisa-avancada')
    ->group(function () {
        Route::get('', [PerfilController::class, 'advancedSearch'])->name('show');
        Route::view('sobre', 'perfis.pesquisa-avancada.about')->name('about');
    });

Route::resource('perfis', PerfilController::class)
    ->parameters(['perfis' => 'perfil'])
    ->except('index');

Route::name('contato.')
    ->middleware('guest')
    ->group(function () {
        Route::get('contato', [ContatoController::class, 'show'])->name('show');
        Route::post('contato', [ContatoController::class, 'send'])->name('send');
    });

Route::name('admin.')
    ->prefix('admin')
    ->middleware([
        'auth',
        TecnicoPermission::class
    ])
    ->group(function () {
        Route::view('', 'admin.home')->name('home');

        Route::post('unidades/datatables', [UnidadeController::class, 'datatables'])->name('unidades.datatables');
        Route::resource('unidades', UnidadeController::class);

        Route::post('setores/datatables', [SetorController::class, 'datatables'])->name('setores.datatables');
        Route::resource('setores', SetorController::class)->parameters(['setores' => 'setor']);

        Route::post('materiais/datatables', [MaterialController::class, 'datatables'])->name('materiais.datatables');
        Route::resource('materiais', MaterialController::class)
            ->parameters(['materiais' => 'material'])
            ->scoped(['material' => 'catmat'])
            ->whereNumber('material');

        Route::post('compras/datatables', [CompraController::class, 'datatables'])->name('compras.datatables');
        Route::resource('compras', CompraController::class)
            ->scoped(['compra' => 'ano'])
            ->whereNumber('compra');

        Route::post(
            'compras/{compra:ano}/materiais/datatables',
            [MaterialCompraController::class, 'datatables']
        )->name('compras.materiais.datatables');
        Route::post(
            'compras/{compra:ano}/materiais/valores-datatables',
            [MaterialCompraController::class, 'valoresDatatables']
        )->name('compras.materiais.valores-datatables');
        Route::resource('compras.materiais', MaterialCompraController::class)
            ->parameters(['materiais' => 'material'])
            ->whereNumber(['compra', 'material'])
            ->except('index');

        Route::middleware(AdminPermission::class)->group(function () {
            Route::post('users/datatables', [UserController::class, 'datatables'])->name('users.datatables');
            Route::resource('users', UserController::class);
        });
    });

Route::get('home', function () {
    return to_route(
        auth()->user()?->hasPermission(UserPermission::Tecnico)
            ? 'admin.home'
            : 'portal.home'
    );
})->name('home');

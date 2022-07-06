<?php

use App\Enums\Categorias;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\SetorController;
use App\Http\Controllers\Admin\UnidadeController;
use App\Http\Controllers\PerfilController;
use App\Models\Perfil;
use App\Models\User;
use App\Notifications\ContatoNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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

Route::view('', 'home')->name('home');

Route::get("categorias/{slug}", function (Request $request, string $slug) {
    foreach (Categorias::cases() as $case)
        if ($case->slug() == $slug)
            $categoria = $case;

    if (!isset($categoria))
        return abort(404, __('not_found', ['target' => 'Categoria']));

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

Route::name('perfis.pesquisa-avancada.')
    ->prefix('pesquisa-avancada')
    ->group(function () {
        Route::get('', PerfilController::class . '@advancedSearch')->name('show');

        Route::view('sobre', 'perfis.pesquisa-avancada.about')->name('about');
    });

Route::resource('perfis', PerfilController::class)
    ->parameters(['perfis' => 'perfil'])
    ->except('index');

Route::name('contato.')
    ->group(function () {
        Route::view('contato', 'contato.show')->name('show');

        Route::post('contato', function (Request $request) {
            Notification::send(
                User::all(),
                new ContatoNotification($request->validate([
                    'nome' => [
                        'required',
                        'string',
                        'max:255',
                    ],
                    'email' => [
                        'required',
                        'string',
                        'max:255',
                        'email',
                    ],
                    'assunto' => [
                        'required',
                        'string',
                        'max:255',
                    ],
                    'mensagem' => [
                        'required',
                        'string',
                        'max:1000',
                    ],
                ]))
            );
            return redirect()->route('home')->with('success', 'Mensagem Enviada.');
        })->name('send');
    });

Route::name('admin.')
    ->prefix('admin')
    ->middleware('auth')
    ->group(function () {
        Route::view('', 'admin.home')
            ->name('home');
        Route::resource('unidades', UnidadeController::class)
            ->except('show');
        Route::resource('setores', SetorController::class)
            ->parameters(['setores' => 'setor'])
            ->except('show');
        Route::resource('itens', ItemController::class)
            ->parameters(['itens' => 'item']);
    });

<?php

use App\Enums\CategoriaPerfil;
use App\Enums\UserPermission;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\MaterialCompraController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\SetorController;
use App\Http\Controllers\Admin\UnidadeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PerfilController;
use App\Http\Middleware\AdminPermission;
use App\Http\Middleware\TecnicoPermission;
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

Route::view('', 'home')->name('portal.home');

Route::get("categorias/{slug}", function (Request $request, string $slug) {
    foreach (CategoriaPerfil::cases() as $case)
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
            return to_route('home')->with('success', 'Mensagem Enviada.');
        })->name('send');
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

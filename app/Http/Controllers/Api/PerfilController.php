<?php

namespace App\Http\Controllers\Api;

use App\Enums\Categorias;
use App\Http\Controllers\Controller;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rules\Enum;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        extract($request->validate([
            'categoria' => [
                new Enum(Categorias::class)
            ]
        ]));

        return new AnonymousResourceCollection(
            Perfil::where(['categoria' => $categoria])->paginate(),
            JsonResource::class
        );
    }
}

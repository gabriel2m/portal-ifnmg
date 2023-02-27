<?php

namespace App\Http\Controllers\Api;

use App\Enums\CategoriaPerfil;
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
        return new AnonymousResourceCollection(
            Perfil::where(
                $request->validate([
                    'categoria' => [
                        new Enum(CategoriaPerfil::class)
                    ]
                ])
            )->paginate(),
            JsonResource::class
        );
    }
}

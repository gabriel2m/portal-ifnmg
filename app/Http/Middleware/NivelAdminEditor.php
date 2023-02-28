<?php

namespace App\Http\Middleware;

use App\Enums\NivelUser;

class NivelAdminEditor extends AbstractNivel
{
    protected $niveis = [
        NivelUser::Admin,
        NivelUser::Editor
    ];
}

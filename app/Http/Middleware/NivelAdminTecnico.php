<?php

namespace App\Http\Middleware;

use App\Enums\NivelUser;

class NivelAdminTecnico extends AbstractNivel
{
    protected $niveis = [
        NivelUser::Admin,
        NivelUser::Tecnico
    ];
}

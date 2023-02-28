<?php

namespace App\Http\Middleware;

use App\Enums\NivelUser;

class NivelTecnico extends AbstractNivel
{
    protected $niveis = [NivelUser::Tecnico];
}

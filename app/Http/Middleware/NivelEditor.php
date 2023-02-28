<?php

namespace App\Http\Middleware;

use App\Enums\NivelUser;

class NivelEditor extends AbstractNivel
{
    protected $niveis = [NivelUser::Editor];
}

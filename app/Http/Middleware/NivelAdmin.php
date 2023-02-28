<?php

namespace App\Http\Middleware;

use App\Enums\NivelUser;

class NivelAdmin extends AbstractNivel
{
    protected $niveis = [NivelUser::Admin];
}

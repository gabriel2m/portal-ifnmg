<?php

namespace App\Http\Middleware;

use App\Enums\UserPermission;

class TecnicoPermission extends AbstractPermission
{
    protected UserPermission $permission = UserPermission::Tecnico;
}

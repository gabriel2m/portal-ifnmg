<?php

namespace App\Http\Middleware;

use App\Enums\UserPermission;

class AdminPermission extends AbstractPermission
{
    protected UserPermission $permission = UserPermission::Admin;
}

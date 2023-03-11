<?php

namespace App\Http\Middleware;

use App\Enums\UserPermission;

class EditorPermission extends AbstractPermission
{
    protected UserPermission $permission = UserPermission::Editor;
}

<?php

namespace App\Enums;

enum NivelUser: int
{
    use EnumTrait;

    case Admin = 1;
    case Tecnico = 2;
    case Editor = 3;

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Tecnico => 'Técnico',
            self::Editor => 'Editor',
        };
    }

    public function permissions(): string
    {
        return match ($this) {
            self::Admin => UserPermission::Admin->value | UserPermission::Tecnico->value | UserPermission::Editor->value,
            self::Tecnico => UserPermission::Tecnico->value | UserPermission::Editor->value,
            self::Editor => UserPermission::Editor->value,
        };
    }

    public function hasPermission(UserPermission $permission): bool
    {
        return boolval($this->permissions() & $permission->value);
    }
}

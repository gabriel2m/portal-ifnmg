<?php

namespace App\Enums;

enum UserPermission: int
{
    use EnumTrait;

    case Tecnico = 1;
    case Editor = 2;
    case Admin = 4;

    public function label(): string
    {
        return match ($this) {
            self::Tecnico => 'Técnico',
            self::Editor => 'Editor',
            self::Admin => 'Admin',
        };
    }
}

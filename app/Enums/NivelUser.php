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
}

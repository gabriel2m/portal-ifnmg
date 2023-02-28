<?php

namespace App\Enums;

enum TipoMaterial: int
{
    use EnumTrait;

    case Consumo = 1;
    case Permanente = 2;

    public function label(): string
    {
        return match ($this) {
            self::Consumo => 'Consumo',
            self::Permanente => 'Permanente',
        };
    }
}

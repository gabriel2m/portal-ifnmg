<?php

namespace App\Enums;

trait EnumTrait
{
    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels()
    {
        return collect(self::cases())->mapWithKeys(
            fn ($case) => [$case->value => $case->label()]
        );
    }
}

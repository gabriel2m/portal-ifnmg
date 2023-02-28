<?php

namespace App\Enums;

trait ValuesTrait
{
    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}

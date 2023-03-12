<?php

namespace App\Models\Traits;

trait TableName
{
    private static string $table_name;

    public static function tableName(): string
    {
        return static::$table_name ??= static::make()->getTable();
    }

    public static function columnName(string $attr): string
    {
        return static::tableName() . ".$attr";
    }
}

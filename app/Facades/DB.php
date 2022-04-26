<?php

namespace App\Facades;

use Illuminate\Support\Facades\DB as FacadesDB;
use App\Exceptions\RollbackTransactionException;

class DB extends FacadesDB
{
    public static function onTrueTransaction(\Closure $callback): bool
    {
        try {
            static::transaction(function () use ($callback) {
                if (!$callback())
                    throw new RollbackTransactionException;
            });
            return true;
        } catch (RollbackTransactionException) {
            return false;
        }
    }
}

<?php

use Illuminate\Support\HtmlString;

if (!function_exists('reais')) {
    /**
     * Format a number in BRL currency
     */
    function reais($val)
    {
        if (is_numeric($val)) {
            return new HtmlString('R$&nbsp' . number_format((float) $val, 2, ',', '.'));
        }
    }
}

if (!function_exists('int_br')) {
    /**
     * Format a integer in BR standard
     */
    function int_br($val)
    {
        if (is_numeric($val)) {
            return number_format($val, 0, ',', '.');
        }
    }
}

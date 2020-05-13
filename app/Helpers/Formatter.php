<?php


namespace App\Helpers;


class Formatter
{
    public static function currency($value): string
    {
        return number_format($value, 2);
    }
}

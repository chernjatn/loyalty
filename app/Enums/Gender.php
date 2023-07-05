<?php

namespace App\Enums;

enum Gender: string
{
    case M = 'm';
    case F = 'f';

    public static function getDescription($value): string
    {
        return __('common.gender.' . $value);
    }
}

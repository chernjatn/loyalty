<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class Gender extends Enum
{
    const M = 'm';
    const F = 'f';

    public static function getDescription($value): string
    {
        return __('common.gender.' . $value);
    }
}

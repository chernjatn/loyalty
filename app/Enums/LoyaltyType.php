<?php

namespace App\Enums;


enum LoyaltyType: int
{
    case ozerki      = 1;
    case stoletov    = 2;
    case superapteka = 3;
    case samson      = 4;

    public function template(): int
    {
        return match($this)
        {
            self::ozerki      => 36,
            self::stoletov    => 34,
            self::samson      => 35,
            self::superapteka => 33,
        };
    }
}

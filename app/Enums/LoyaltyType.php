<?php

namespace App\Enums;


enum LoyaltyType: int
{
    case OZERKI      = 1;
    case STOLETOV    = 2;
    case SUPERAPTEKA = 3;
    case SAMSON      = 4;

    public function template(): int
    {
        return match($this)
        {
            self::OZERKI      => 36,
            self::STOLETOV    => 34,
            self::SAMSON      => 35,
            self::SUPERAPTEKA => 33,
        };
    }

    public function projectLogin(): string
    {
        return match($this)
        {
            self::OZERKI      => "SiteOz",
            self::STOLETOV    => "Stoletov",
            self::SAMSON      => "SamsonFarma",
            self::SUPERAPTEKA => "SuperApteka",
        };
    }
}

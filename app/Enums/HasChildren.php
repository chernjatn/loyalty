<?php

namespace App\Enums;

enum HasChildren: int
{
    case DEFAULT          = 1;
    case HAS_CHILDREN     = 2;
    case HAS_NO_CHILDREN  = 3;


public function valueForManzana(): int
{
    return match($this)
    {
        self::DEFAULT => 1,
        self::HAS_CHILDREN => 200000,
        self::HAS_NO_CHILDREN => 200001
    };
}
}

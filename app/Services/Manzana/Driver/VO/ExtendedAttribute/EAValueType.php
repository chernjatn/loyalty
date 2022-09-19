<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\ExtendedAttribute;

enum EAValueType: int
{
    case DECIMAL  = 1;
    case TEXT     = 2;
    case DATETIME = 3;
}

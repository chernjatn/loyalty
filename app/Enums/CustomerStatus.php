<?php

namespace App\Enums;

enum CustomerStatus: int
{
    case DISABLED = 0;
    case ACTIVE = 1;
    case NOT_ACTIVATED = 2;
}

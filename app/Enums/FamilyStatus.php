<?php

namespace App\Enums;

enum FamilyStatus: int
{
    case NOT_MERRIED = 1;
    case MERRIED     = 2;
    case DIVORCED    = 3;
    case WIDOWER     = 4;
}

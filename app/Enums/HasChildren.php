<?php

namespace App\Enums;

enum HasChildren: int
{
    case DEFAULT          = 1;
    case HAS_CHILDREN     = 2;
    case HAS_NO_CHILDREN  = 3;
}

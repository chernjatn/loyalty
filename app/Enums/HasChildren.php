<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class HasChildren extends Enum
{
    const default          = 1;
    const has_children     = 2;
    const has_no_children  = 3;
}

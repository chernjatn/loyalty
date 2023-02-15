<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class HasChildren extends Enum
{
    const DEFAULT          = 1;
    const HAS_CHILDREN     = 2;
    const HAS_NO_CHILDREN  = 3;
}

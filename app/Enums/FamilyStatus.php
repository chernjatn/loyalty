<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class FamilyStatus extends Enum
{
    const NOT_MERRIED = 1;
    const MERRIED     = 2;
    const DIVORCED    = 3;
    const WIDOWER     = 4;
}

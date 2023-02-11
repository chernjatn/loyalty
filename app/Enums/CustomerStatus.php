<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class CustomerStatus extends Enum
{
    const DISABLED = 0;
    const ACTIVE = 1;
    const NOT_ACTIVATED = 2;

}

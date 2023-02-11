<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

class ContactType extends Enum
{
    const ANY              = 1;
    const EMAIL            = 2;
    const PHONE            = 3;
    const POST             = 4;
    const EMAIL_AND_PHONE  = 5;
}

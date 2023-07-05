<?php

namespace App\Enums;


enum ContactType: int
{
    case ANY              = 1;
    case EMAIL            = 2;
    case PHONE            = 3;
    case POST             = 4;
    case EMAIL_AND_PHONE  = 5;
}

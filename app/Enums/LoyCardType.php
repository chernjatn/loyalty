<?php

namespace App\Enums;

use LogicException;
use Illuminate\Support\Facades\Storage;

enum LoyCardType: string
{
    case SUPERAPTEKA   = 'superapteka';
    case SUPERSAMSON   = 'supersamson';
    case ZOZ           = 'zoz';
    case VASHE_PR_RESH = 'vpr';
    case PULS_ZDOROVYA = 'pz';
    case YA_BUDU_JIT   = 'ya_budu_jit';
    case KARTA_ZDORV   = 'kz';
    case APTEKA_RU     = 'apteka_ru';

    public static function fromChannel(LoyaltyType $loyaltyType): self
    {
        switch ($loyaltyType->value) {
            case LoyaltyType::ozerki:
                return LoyCardType::ZOZ;
            case LoyaltyType::samson:
                return LoyCardType::SUPERSAMSON;
            case LoyaltyType::stoletov:
                return LoyCardType::YA_BUDU_JIT;
            case LoyaltyType::superapteka:
                return LoyCardType::SUPERAPTEKA;
        }
        throw new LogicException('No loyCardType for channel:' . $loyaltyType->value);
    }
}

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

    public static function fromLoyalty(LoyaltyType $loyaltyType): self
    {
        switch ($loyaltyType->value) {
            case LoyaltyType::OZERKI:
                return LoyCardType::ZOZ;
            case LoyaltyType::SAMSON:
                return LoyCardType::SUPERSAMSON;
            case LoyaltyType::STOLETOV:
                return LoyCardType::YA_BUDU_JIT;
            case LoyaltyType::SUPERAPTEKA:
                return LoyCardType::SUPERAPTEKA;
        }

        throw new LogicException('No loyCardType for channel:' . $loyaltyType->value);
    }
}

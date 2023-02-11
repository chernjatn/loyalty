<?php

namespace App\Enums;

use LogicException;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Facades\Storage;

class LoyCardType extends Enum implements LocalizedEnum
{
    const SUPERAPTEKA   = 'superapteka';
    const SUPERSAMSON   = 'supersamson';
    const ZOZ           = 'zoz';
    const VASHE_PR_RESH = 'vpr';
    const PULS_ZDOROVYA = 'pz';
    const YA_BUDU_JIT   = 'ya_budu_jit';
    const KARTA_ZDORV   = 'kz';
    const APTEKA_RU     = 'apteka_ru';

    public static function fromChannel(LoyaltyType $loyaltyType): self
    {
        switch ($loyaltyType->value) {
            case LoyaltyType::ozerki:
                return self::fromValue(self::ZOZ);
            case LoyaltyType::samson:
                return self::fromValue(self::SUPERSAMSON);
            case LoyaltyType::stoletov:
                return self::fromValue(self::YA_BUDU_JIT);
            case LoyaltyType::superapteka:
                return self::fromValue(self::SUPERAPTEKA);
        }
        throw new LogicException('No loyCardType for channel:' . $loyaltyType->value);
    }

    public function getImagePath(): string
    {
        return Storage::url('loycard/' . $this->value . '.svg');
    }
}

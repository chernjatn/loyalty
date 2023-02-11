<?php

namespace App\Entity;
//use Money\Money;
use App\Enums\LoyCardType;

class LoyCard
{
    public function __construct(
        private string $number,
        //private LoyCardType $type,
        private ?int $balance = null
    ) {
    }

    public function getNumber(): string
    {
        return $this->number;
    }

//    public function getType(): LoyCardType
//    {
//        return $this->type;
//    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function is(LoyCard $loyCard): bool
    {
        return $loyCard->getType()->is($this->type) && $loyCard->getNumber() === $this->getNumber();
    }
}


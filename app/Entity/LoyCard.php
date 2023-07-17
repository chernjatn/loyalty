<?php

namespace App\Entity;
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

    public function getBalance(): ?int
    {
        return $this->balance;
    }
}


<?php

namespace App\Entity;

class LoyCard
{
    public function __construct(
        public readonly string $number,
        public readonly ?int $balance = null,
    ) {
    }
}

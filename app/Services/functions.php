<?php

use App\Enums\LoyaltyType;

function loyaltyType(): LoyaltyType
{
    return app(LoyaltyType::class);
}

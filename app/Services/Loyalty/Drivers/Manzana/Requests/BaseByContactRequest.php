<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Enums\LoyaltyType;
use App\Entity\LoyaltyCustomer;

abstract class BaseByContactRequest extends JSONRequest
{
    public function __construct(LoyaltyType $loyaltyType, protected LoyaltyCustomer $contact)
    {
        parent::__construct($loyaltyType);
    }
}

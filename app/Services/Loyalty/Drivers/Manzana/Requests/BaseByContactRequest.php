<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Entity\LoyaltyCustomer;
use App\Enums\LoyaltyType;

abstract class BaseByContactRequest extends JSONRequest
{
    public function __construct(LoyaltyType $loyaltyType, protected LoyaltyCustomer $contact)
    {
        parent::__construct($loyaltyType);
    }
}

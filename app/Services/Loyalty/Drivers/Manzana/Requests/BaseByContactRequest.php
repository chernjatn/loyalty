<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Enums\LoyaltyType;
use App\Entity\Contact;

abstract class BaseByContactRequest extends JSONRequest
{
    public function __construct(LoyaltyType $loyaltyType, protected Contact $contact)
    {
        parent::__construct($loyaltyType);
    }
}

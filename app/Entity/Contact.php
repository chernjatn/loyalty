<?php

namespace App\Entity;

class Contact extends LoyaltyCustomer
{
    public function __construct(
        string $id,
        Phone  $mobilePhone
    )
    {
        parent::__construct(
            $id,
            $mobilePhone,
        );
    }
}

<?php

namespace App\Entity;

class Contact extends LoyaltyCustomer
{
    public function __construct(
        protected string $id,
        protected Phone $mobilePhone,
    ) {
        parent::__construct(
            $id,
            $mobilePhone,
        );
    }

    public function getId(): string
    {
        return $this->id;
    }
}

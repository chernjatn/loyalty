<?php

namespace App\Entity;

class Contact extends LoyaltyCustomer
{
    public function __construct(
        protected string $id,
        Phone $phone,
        ?string $email,
        bool $isPhoneVerified,
        bool $isEmailVerified,
    ) {
        parent::__construct(
            $phone,
            $email,
            $isPhoneVerified,
            $isEmailVerified,
        );
    }

    public function getId(): string
    {
        return $this->id;
    }
}

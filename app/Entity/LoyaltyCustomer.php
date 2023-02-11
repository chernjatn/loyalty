<?php

namespace App\Entity;

class LoyaltyCustomer
{
    function __construct(
        protected Phone $phone,
        protected ?string $email,
        protected bool $isPhoneVerified,
        protected bool $isEmailVerified,
    ) {
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function isPhoneVerified(): bool
    {
        return $this->isPhoneVerified;
    }

    public function isEmailVerified(): bool
    {
        return $this->isEmailVerified;
    }
}


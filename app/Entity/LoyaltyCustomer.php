<?php

namespace App\Entity;

class LoyaltyCustomer
{
    function __construct(
        protected string $id,
        protected Phone $mobilePhone,
        protected ?string $lastName = null,
        protected ?string $firstName = null,
        protected ?string $middleName = null,
        protected ?int $genderCode = null,
        protected ?string $birthDate = null,
        protected ?int $familyStatusCode = null,
        protected ?int $hasChildrenCode = null,
        protected ?string $emailAddress = null,
        protected ?bool $isPhoneVerified = null,
        protected ?bool $isEmailVerified = null,
        protected ?bool $allowNotification = null,
        protected ?bool $allowEmail = null,
        protected ?bool $allowSms = null,
        protected ?bool $allowPhone = null,
        protected ?bool $allowPush = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPhone(): Phone
    {
        return $this->mobilePhone;
    }

    public function getEmail(): ?string
    {
        return $this->emailAddress;
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


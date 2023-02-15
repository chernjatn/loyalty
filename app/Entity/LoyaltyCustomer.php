<?php

namespace App\Entity;

class LoyaltyCustomer
{
    function __construct(
        protected string $id,
        protected Phone $mobilePhone,
        protected string $lastName,
        protected string $firstName,
        protected string $middleName,
        protected int $genderCode,
        protected ?string $birthDate,
        protected ?int $familyStatusCode,
        protected int $hasChildrenCode,
        protected ?string $emailAddress,
        protected ?bool $allowNotification,
        protected ?bool $allowEmail,
        protected ?bool $allowSms,
        protected ?bool $allowPhone,
        protected ?bool $allowPush,
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

    public function getFamilyStatusCode(): ?int
    {
        return $this->familyStatusCode;
    }

    public function getHasChildrenCode(): int
    {
        return $this->hasChildrenCode;
    }

    public function getAllowNotification(): ?bool
    {
        return $this->allowNotification;
    }

    public function getAllowPhone(): ?bool
    {
        return $this->allowPhone;
    }

    public function getAllowSms(): ?bool
    {
        return $this->allowSms;
    }

    public function getAllowPush(): ?bool
    {
        return $this->allowPush;
    }

    public function getAllowEmail(): ?bool
    {
        return $this->allowEmail;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function getGenderCode(): int
    {
        return $this->genderCode;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getProperties(): array
    {
        return get_object_vars($this);
    }
}


<?php

namespace App\Entity;

class LoyaltyCustomer
{
    function __construct(
        protected readonly string $id,
        protected readonly Phone $mobilePhone,
        protected readonly ?string $lastName,
        protected readonly ?string $firstName,
        protected readonly ?string $middleName,
        protected readonly ?int $genderCode,
        protected readonly ?string $birthDate,
        protected readonly ?int $familyStatusCode,
        protected readonly int $hasChildrenCode,
        protected readonly ?string $emailAddress,
        protected readonly ?bool $allowNotification,
        protected readonly ?bool $allowEmail,
        protected readonly ?bool $allowSms,
        protected readonly ?bool $allowPhone,
        protected readonly ?bool $allowPush,
    ) {
    }
}


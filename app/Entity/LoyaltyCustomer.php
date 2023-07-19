<?php

namespace App\Entity;

class LoyaltyCustomer
{
    public function __construct(
        public readonly string $id,
        public readonly Phone $phone,
        public readonly ?string $lastName = null,
        public readonly ?string $firstName = null,
        public readonly ?string $middleName = null,
        public readonly ?int $genderCode = null,
        public readonly ?string $birthDate = null,
        public readonly ?int $familyStatusCode = null,
        public readonly ?int $hasChildrenCode = null,
        public readonly ?int $communicationMethod = null,
        public readonly ?string $emailAddress = null,
        public readonly ?bool $allowNotification = null,
        public readonly ?bool $allowEmail = null,
        public readonly ?bool $allowSms = null,
        public readonly ?bool $allowPhone = null,
        public readonly ?bool $allowPush = null,
    ) {
    }
}

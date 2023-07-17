<?php

namespace App\Entity;

use Carbon\Carbon;

class LoyaltyCustomer
{
    function __construct(
        public readonly string $id,
        public readonly Phone $phone,
        public readonly ?string $lastName,
        public readonly ?string $firstName,
        public readonly ?string $middleName,
        public readonly ?int $genderCode,
        public readonly ?Carbon $birthDate,
        public readonly ?int $familyStatusCode,
        public readonly int $hasChildrenCode,
        public readonly ?string $emailAddress,
        public readonly ?bool $allowNotification,
        public readonly ?bool $allowEmail,
        public readonly ?bool $allowSms,
        public readonly ?bool $allowPhone,
        public readonly ?bool $allowPush,
    ) {
    }
}


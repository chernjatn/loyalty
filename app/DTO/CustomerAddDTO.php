<?php

namespace App\DTO;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enums\FamilyStatus;
use App\Enums\HasChildren;
use App\Enums\ContactType;
use App\Entity\Phone;
use App\Enums\Gender;

class CustomerAddDTO
{
    protected Phone $phone;
    protected string $firstName;
    protected string $lastName;
    protected ?string $emailAddress;
    protected ?string $middleName     = null;
    protected bool $allowNotification = true;
    protected bool $allowEmail        = true;
    protected bool $allowSms          = true;
    protected bool $allowPhone        = true;
    protected bool $allowPush         = true;
    protected ?Carbon $birthDate      = null;
    protected ?Gender $genderCode     = null;
    protected ?FamilyStatus $familyStatusCode    = null;
    protected ?HasChildren $hasChildrenCode      = null;
    protected ?ContactType $communicationMethod  = null;


    public function __construct(array $fields)
    {
        $this->emailAddress      = $fields['emailAddress'] ?? null;
        $this->phone             = new Phone($fields['phone']);
        $this->firstName         = Str::title($fields['firstName']);
        $this->lastName          = Str::title($fields['lastName']);
        $this->middleName        = Str::title($fields['middleName'] ?? '');
        $this->allowNotification = !empty($fields['allowNotification']);
        $this->allowEmail        = !empty($fields['allowEmail']);
        $this->allowSms          = !empty($fields['allowSms']);
        $this->allowPhone        = !empty($fields['allowPhone']);
        $this->allowPush         = !empty($fields['allowPush']);

        if (isset($fields['birthDate'])) {
            $this->birthDate = Carbon::parse($fields['birthDate']);
        }

        if (isset($fields['communicationMethod'])) {
            $this->communicationMethod = ContactType::from($fields['communicationMethod']);
        }

        if (isset($fields['genderCode'])) {
            $this->genderCode = Gender::from($fields['genderCode']);
        }

        if (isset($fields['familyStatusCode'])) {
            $this->familyStatusCode = FamilyStatus::from($fields['familyStatusCode']);
        }

        if (isset($fields['hasChildrenCode'])) {
            $this->hasChildrenCode = HasChildren::from($fields['hasChildrenCode']);
        }
    }

    public function getGender(): ?Gender
    {
        return $this->genderCode;
    }

    public function getBirthdate(): ?Carbon
    {
        return $this->birthDate;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->emailAddress;
    }

    public function getCommunicationMethod(): ?ContactType
    {
        return $this->communicationMethod;
    }

    public function getFamilyStatusCode(): ?FamilyStatus
    {
        return $this->familyStatusCode;
    }

    public function getHasChildrenCode(): ?HasChildren
    {
        return $this->hasChildrenCode;
    }

    public function getEmailAgree(): bool
    {
        return $this->allowEmail;
    }

    public function getSmsAgree(): bool
    {
        return $this->allowSms;
    }

    public function getPhoneAgree(): bool
    {
        return $this->allowPhone;
    }

    public function getPushAgree(): bool
    {
        return $this->allowPush;
    }
}

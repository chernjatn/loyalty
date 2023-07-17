<?php

namespace App\DTO;

use App\Enums\FamilyStatus;
use App\Enums\HasChildren;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enums\ContactType;
use App\Entity\Phone;
use App\Enums\CustomerStatus;
use App\Enums\Gender;

class CustomerAddDTO
{
    protected Phone  $mobilePhone;
    protected string $firstName;
    protected string $lastName;
    protected ?string $emailAddress;
    protected ?string $secondName     = null;
    protected bool $allowNotification = true;
    protected bool $allowEmail        = true;
    protected bool $allowSms          = true;
    protected bool $allowPhone        = true;
    protected bool $allowPush         = true;
    protected ?ContactType $prefConn  = null;
    protected ?Carbon $birthDate      = null;
    protected ?Gender $genderCode     = null;
    protected CustomerStatus $status;
    protected ?FamilyStatus $familyStatusCode;
    protected HasChildren $hasChildren;

    public function __construct(array $fields)
    {
        $this->emailAddress      = $fields['email'] ?? null;
        $this->mobilePhone       = new Phone($fields['phone']);
        $this->firstName         = Str::title($fields['firstName']);
        $this->lastName          = Str::title($fields['lastName']);
        $this->secondName        = Str::title($fields['secondName'] ?? '');
        $this->allowNotification = !empty($fields['allowNotification']);
        $this->allowEmail        = !empty($fields['allowEmail']);
        $this->allowSms          = !empty($fields['allowSms']);
        $this->allowPhone        = !empty($fields['allowPhone']);
        $this->allowPush         = !empty($fields['allowPush']);

        if (isset($fields['birthdate'])) {
            $this->birthDate = Carbon::parse($fields['birthdate']);
        }

        if (isset($fields['communicationMethod'])) {
            $this->prefConn = ContactType::from($fields['communicationMethod']);
        }

        if (isset($fields['gender'])) {
            $this->genderCode = Gender::from($fields['gender']);
        }

        if (isset($fields['familyStatusCode'])) {
            $this->familyStatusCode = !is_null($fields['familyStatusCode']) ? FamilyStatus::from($fields['familyStatusCode']) : null;
        }

        if (isset($fields['hasChildren'])) {
            $this->hasChildren = HasChildren::from($fields['familyStatusCode']);
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

    public function getSecondName(): ?string
    {
        return $this->secondName;
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
        return $this->mobilePhone;
    }

    public function getEmail(): ?string
    {
        return $this->emailAddress;
    }

    public function getPrefConn(): ?ContactType
    {
        return $this->prefConn;
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

    public function getStatus(): CustomerStatus
    {
        return $this->status;
    }
}

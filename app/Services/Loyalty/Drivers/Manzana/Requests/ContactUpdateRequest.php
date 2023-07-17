<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Enums\LoyaltyType;
use App\DTO\CustomerAddDTO;
use App\Enums\Gender;
use App\Entity\Contact;

class ContactUpdateRequest extends JSONRequest
{
    private const REQUEST_APE_PATH  = '/Contact/Update';
    private CustomerAddDTO $customerAddDTO;

    public function __construct(LoyaltyType $loyaltyType, CustomerAddDTO $customerAddDTO)
    {
        parent::__construct($loyaltyType);
        $this->customerAddDTO = $customerAddDTO;
    }


    /** @return ?Contact */
    public function processRequest()
    {
        return transform(
            $this->post(
                $this->managerDomain . self::REQUEST_APE_PATH,
                $this->preparePostSuperQuery(['Entity' => $this->getContactFields()]),
                'value'
            ),
            fn ($contactId) => new Contact($contactId, $this->customerAddDTO->getPhone())
        );
    }

    protected function getContactFields()
    {
        $gender = 0;
        if ($this->customerAddDTO->getGender()) {
            $gender = $this->customerAddDTO->getGender()->value == 'm' ? 1 : 0;
        }

        return [
            'MobilePhone'       => '+' . $this->customerAddDTO->getPhone()->getPhoneNumber(),
            'EmailAddress'      => $this->customerAddDTO->getEmail(),
            'Firstname'         => $this->customerAddDTO->getFirstname(),
            'Lastname'          => $this->customerAddDTO->getLastname(),
            'MiddleName'        => $this->customerAddDTO->getMiddleName() ?? '',
            'BirthDate'         => $this->customerAddDTO->getBirthdate()->format('d-m-y H:i:s'),
            'GenderCode'        => $gender,
            'AllowNotification' => $this->customerAddDTO->getEmailAgree(),
            'AllowEmail'        => $this->customerAddDTO->getEmailAgree(),
            'AllowSms'          => $this->customerAddDTO->getSmsAgree(),
            'AllowPhone'        => $this->customerAddDTO->getPhoneAgree(),
            'AllowPush'         => $this->customerAddDTO->getPushAgree(),
            'AgreeToTerms'      => true,
            'appid'             => $this->appId
        ];
    }
}

<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\DTO\CustomerAddDTO;
use App\Entity\Contact;
use App\Enums\LoyaltyType;

class ContactCreateRequest extends JSONRequest
{
    private const REQUEST_APE_PATH = '/Contact/Create';
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
        return [
            'MobilePhone' => '+' . $this->customerAddDTO->getPhone()->getPhoneNumber(),
            'EmailAddress' => $this->customerAddDTO->getEmail(),
            'Firstname' => $this->customerAddDTO->getFirstname(),
            'Lastname' => $this->customerAddDTO->getLastname(),
            'MiddleName' => $this->customerAddDTO->getMiddleName() ?? '',
            'BirthDate' => $this->customerAddDTO->getBirthdate()->format('Y-m-d'),
            'GenderCode' => $this->customerAddDTO->getGender()->value,
            'FamilyStatusCode' => $this->customerAddDTO->getFamilyStatusCode()?->value,
            'HasChildrenCode' => $this->customerAddDTO->getHasChildrenCode()?->valueForManzana(),
            'CommunicationMethod' => $this->customerAddDTO->getCommunicationMethod()?->value,
            'AllowNotification' => $this->customerAddDTO->getEmailAgree(),
            'AllowEmail' => $this->customerAddDTO->getEmailAgree(),
            'AllowSms' => $this->customerAddDTO->getSmsAgree(),
            'AllowPhone' => $this->customerAddDTO->getPhoneAgree(),
            'AllowPush' => $this->customerAddDTO->getPushAgree(),
            'AgreeToTerms' => true,
            'appid' => $this->appId,
        ];
    }
}

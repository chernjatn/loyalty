<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\DTO\CustomerAddDTO;
use App\Entity\Contact;
use App\Entity\LoyaltyCustomer;
use App\Enums\LoyaltyType;

class ContactUpdateRequest extends JSONRequest
{
    private const REQUEST_APE_PATH = '/Contact/Update';
    private CustomerAddDTO $customerAddDTO;
    private string $contactId;

    public function __construct(LoyaltyType $loyaltyType, CustomerAddDTO $customerAddDTO, string $contactId)
    {
        parent::__construct($loyaltyType);
        $this->customerAddDTO = $customerAddDTO;
        $this->contactId = $contactId;
    }

    /** @return ?LoyaltyCustomer */
    public function processRequest()
    {
        return transform(
            $this->post(
                $this->managerDomain . self::REQUEST_APE_PATH,
                $this->preparePostSuperQuery(['Entity' => $this->getContactFields()]),
                'value'
            ),
            fn ($contactId) => new LoyaltyCustomer($contactId, $this->customerAddDTO->getPhone())
        );
    }

    protected function getContactFields()
    {
        return [
            'id' => $this->contactId,
            'MobilePhone' => '+' . $this->customerAddDTO->getPhone()->getPhoneNumber(),
            'EmailAddress' => $this->customerAddDTO->getEmail(),
            'FirstName' => $this->customerAddDTO->getFirstname(),
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
        ];
    }
}

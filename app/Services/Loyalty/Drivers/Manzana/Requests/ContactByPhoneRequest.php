<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Entity\LoyaltyCustomer;
use App\Entity\Phone;
use App\Enums\LoyaltyType;

class ContactByPhoneRequest extends JSONRequest
{
    private const CONTACT_FILTER_PATH = '/Contact/FilterByPhoneAndEmail';

    public function __construct(LoyaltyType $loyaltyType, private Phone $phone)
    {
        parent::__construct($loyaltyType);
    }

    public function processRequest(): ?LoyaltyCustomer
    {
        return transform(
            $this->get(
                $this->managerDomain . self::CONTACT_FILTER_PATH,
                $this->prepareSuperQuery([
                    'mobilePhone' => '+' . $this->phone->getPhoneNumber(),
                    'emailAddress' => '',
                    'take' => '1',
                    'skip' => '0',
                ]),
                'value.0'
            ),

            fn (array $resp) => new LoyaltyCustomer(
                $resp['Id'],
                $this->phone,
                $resp['LastName'],
                $resp['FirstName'],
                $resp['MiddleName'],
                $resp['GenderCode'],
                $resp['BirthDate'],
                $resp['FamilyStatusCode'],
                $resp['HasChildrenCode'],
                $resp['CommunicationMethod'],
                $resp['EmailAddress'] ?: null,
                (bool) $resp['AllowNotification'],
                (bool) $resp['AllowEmail'],
                (bool) $resp['AllowSms'],
                (bool) $resp['AllowPhone'],
                (bool) $resp['AllowPush'],
            )
        );
    }
}

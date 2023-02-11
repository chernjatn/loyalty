<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;

class ContactUpdateRequest extends SoapRequest
{
    private Contact $contact;

    public function __construct(Contact $contact)
    {
        parent::__construct();
        $this->contact = $contact;
    }

    public function processRequest(): bool
    {
        $requestBody = [
            'request' => [
                'ContactID'           => $this->contact->getId(),
                'MobilePhone'         => '+' . $this->contact->getPhone()->getPhoneNumber(),
                'MobilePhoneVerified' => true,
                'Organization'        => $this->organization,
                'DateTime'            => date('c'),
            ],
            'orgName' => $this->orgName
        ];

        $response = $this->soapClient->ContactUpdate($requestBody);

        return empty($response->ContactUpdateResult->ErrorCode);
    }
}

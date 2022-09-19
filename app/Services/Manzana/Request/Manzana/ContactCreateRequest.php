<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Webkul\Core\Models\Channel;
use Ultra\Shop\DTO\Entity\CustomerAddDTO;
use Ultra\Shop\Enums\Gender;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;

class ContactCreateRequest extends JSONRequest
{
    private const REQUEST_APE_PATH  = '/Contact/Create';
    private CustomerAddDTO $customerAddDTO;

    public function __construct(Channel $channel, CustomerAddDTO $customerAddDTO)
    {
        parent::__construct($channel);
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
            $gender = $this->customerAddDTO->getGender()->is(Gender::M) ? 1 : 0;
        }

        return [
            'MobilePhone'       => '+' . $this->customerAddDTO->getPhone()->getPhoneNumber(),
            // 'EmailAddress'      => $this->customerAddDTO->getEmail(),
            'Firstname'         => $this->customerAddDTO->getFirstname(),
            'Lastname'          => $this->customerAddDTO->getLastname(),
            'MiddleName'        => $this->customerAddDTO->getSecondName() ?? '',
            'Password'          => $this->customerAddDTO->getPassword(),
            'BirthDate'         => '',
            'GenderCode'        => $gender,
            'AllowNotification' => $this->customerAddDTO->getMailingAgree(),
            'AllowEmail'        => $this->customerAddDTO->getMailingAgree(),
            'AllowSms'          => $this->customerAddDTO->getSmsAgree(),
            'AgreeToTerms'      => true,
            'appid'             => $this->appId
        ];
    }
}

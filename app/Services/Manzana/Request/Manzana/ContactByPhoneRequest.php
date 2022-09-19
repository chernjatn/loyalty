<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Webkul\Core\Models\Channel;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;
use Ultra\Shop\VO\Phone;

class ContactByPhoneRequest extends JSONRequest
{
    private const CONTACT_FILTER_PATH  = '/Contact/FilterByPhoneAndEmail';

    public function __construct(Channel $channel, private Phone $phone)
    {
        parent::__construct($channel);
    }

    public function processRequest(): ?Contact
    {
        return transform(
            $this->get(
                $this->managerDomain . self::CONTACT_FILTER_PATH,
                $this->prepareSuperQuery([
                    'mobilePhone'   => '+' . $this->phone->getPhoneNumber(),
                    'emailAddress'  => '',
                    'take'          => '1',
                    'skip'          => '0'
                ]),
                'value.0'
            ),
            fn (array $resp) => new Contact($resp['Id'], $this->phone)
        );
    }
}

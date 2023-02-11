<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests\ExtendedAttribute;

use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests\JSONRequest;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\ExtendedAttribute\EAValue;
use Webkul\Core\Models\Channel;

class BindRequest extends JSONRequest
{
    private const REQUEST_PATH = '/Contact/BindExtendedAttribute';

    public function __construct(
        Channel $channel,
        private Contact $contact,
        private string $key,
        private EAValue $value,
    ) {
        parent::__construct($channel);
    }

    public function processRequest(): bool
    {
        $attribute = [
            'Type'       => $this->value->getType(),
            'Key'        => $this->key,
            'ExternalId' => null,
            'Text'       => null,
            'DateTime'   => null,
            'Decimal'    => null,
        ];

        $attribute[EAValue::getRawValueKey($this->value->getType())] = $this->value->getRawValue();

        return !is_null(
            $this->post(
                $this->customerDomain . self::REQUEST_PATH,
                $this->preparePostSuperQuery([
                    'Id'                => $this->contact->getId(),
                    'ExtendedAttribute' => $attribute,
                ]),
                'value'
            ),
        );
    }
}

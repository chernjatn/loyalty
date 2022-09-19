<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

class CheckForBindingRequest extends BaseByContactRequest
{
    private const CHECK_PATH  = '/PCValueOptional/CheckForBinding';

    public function processRequest(): bool
    {
        return !is_null(
            $this->post(
                $this->customerDomain . self::CHECK_PATH,
                $this->preparePostSuperQuery([
                    'contactId' => $this->contact->getId(),
                    'partnerId' => $this->partnerId
                ]),
                'value'
            )
        );
    }
}

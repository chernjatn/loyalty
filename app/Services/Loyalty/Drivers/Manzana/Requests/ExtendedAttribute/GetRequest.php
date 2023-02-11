<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests\ExtendedAttribute;

use Illuminate\Support\Collection;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests\BaseByContactRequest;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\ExtendedAttribute\EAValue;

class GetRequest extends BaseByContactRequest
{
    private const REQUEST_PATH = '/ContactExtendedAttribute/GetAllByContact';

    /**
     * @return Collection<string, EAValue>
     */
    public function processRequest(): Collection
    {
        return transform(
            $this->get(
                $this->customerDomain . self::REQUEST_PATH,
                $this->prepareSuperQuery([
                    'contactId' => $this->contact->getId()
                ]),
                'value'
            ),
            static function (array $rawItems) {
                return collect($rawItems)->mapWithKeys(
                    static function ($rawItem) {
                        $val = rescue(static fn () => EAValue::fromRaw($rawItem), null, false);
                        if (empty($val)) {
                            return [];
                        }

                        return [$rawItem['Key'] => $val];
                    }
                );
            },
            static function () {
                return collect();
            },
        );
    }
}

<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Illuminate\Support\Collection;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\CharityFoundation;

class CharityFoundationsRequest extends JSONRequest
{
    private const GET_CHARITY_PATH  = '/Charity/GetAllByPartner';

    public function processRequest(): Collection
    {
        return transform(
            $this->get(
                $this->managerDomain . self::GET_CHARITY_PATH,
                $this->prepareSuperQuery([
                    'partnerId' => $this->partnerId
                ]),
                'value'
            ),
            fn (array $foundations) => collect($foundations)
                ->filter(fn (array $foundation) => $foundation['IsActive'])
                ->map(fn (array $foundation) => new CharityFoundation($foundation['Id'], $foundation['Name'], $foundation['BonusCard'])),
            fn () => new Collection()
        );
    }
}

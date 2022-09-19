<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Illuminate\Support\Collection;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\FavoriteCategory;

class FavoritableCategoriesRequest extends JSONRequest
{
    private const FAVORITABLE_CATEGORIES_PATH  = '/PCValueOptionalProductGroup/GetAllByPartner';

    /**
     * @return Collection<string, FavoriteCategory>
     */
    public function processRequest(): Collection
    {
        return transform(
            $this->get(
                $this->customerDomain . self::FAVORITABLE_CATEGORIES_PATH,
                $this->prepareSuperQuery([
                    'partnerId' => $this->partnerId
                ]),
                'value'
            ),
            fn (array $response) => collect($response)->mapWithKeys(fn (array $item) => [$item['Id'] => new FavoriteCategory($item['Id'], $item['Name'])]),
            fn () => collect()
        );
    }
}

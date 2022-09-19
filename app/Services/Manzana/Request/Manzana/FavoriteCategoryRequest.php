<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Carbon\Carbon;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\FavoriteCategory;

class FavoriteCategoryRequest extends BaseByContactRequest
{
    private const FAVORITE_CATEGORY_PATH  = '/PCValueOptional/GetAllByContact';

    public function processRequest(): ?FavoriteCategory
    {
        return transform(
            $this->get(
                $this->customerDomain . self::FAVORITE_CATEGORY_PATH,
                $this->prepareSuperQuery([
                    'contactId' => $this->contact->getId()
                ]),
                'value.0'
            ),
            fn ($response) => new FavoriteCategory($response['Id'], $response['ProductGroupName'], !empty($response['ActualEnd']) ? Carbon::parse($response['ActualEnd']) : null)
        );
    }
}

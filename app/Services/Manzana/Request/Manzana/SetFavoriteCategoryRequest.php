<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Ultra\Shop\Contracts\Loyalty\FavoriteCategory;
use Webkul\Core\Models\Channel;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;

class SetFavoriteCategoryRequest extends JSONRequest
{
    private const SET_FAVORITE_CATEGORY_PATH  = '/PCValueOptional/Create';
    private Contact $contact;
    private FavoriteCategory $favoriteCategory;

    public function __construct(Channel $channel, Contact $contact, FavoriteCategory $favoriteCategory)
    {
        parent::__construct($channel);
        $this->contact = $contact;
        $this->favoriteCategory = $favoriteCategory;
    }

    public function processRequest(): bool
    {
        return (bool) $this->post(
            $this->customerDomain . self::SET_FAVORITE_CATEGORY_PATH,
            $this->preparePostSuperQuery([
                'contactId'      => $this->contact->getId(),
                'ProductGroupId' => $this->favoriteCategory->getGuid(),
                'partnerId'      => $this->partnerId
            ]),
            'value'
        );
    }
}

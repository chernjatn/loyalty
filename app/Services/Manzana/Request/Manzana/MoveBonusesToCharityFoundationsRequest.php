<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Money\Money;
use Webkul\Core\Models\Channel;
use Ultra\Shop\Contracts\Loyalty\CharityFoundation;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\Contact;

class MoveBonusesToCharityFoundationsRequest extends JSONRequest
{
    private const MOVE_CHARITY_PATH  = '/Bonus/MoveCharity';

    private Contact $contact;
    private CharityFoundation $charityFoundation;
    private Money $bonuses;

    public function __construct(Channel $channel, Contact $contact, CharityFoundation $charityFoundation, Money $bonuses)
    {
        parent::__construct($channel);
        $this->contact = $contact;
        $this->charityFoundation = $charityFoundation;
        $this->bonuses = $bonuses;
    }

    public function processRequest(): bool
    {
        return (bool) $this->post(
            $this->customerDomain . self::MOVE_CHARITY_PATH,
            $this->preparePostSuperQuery([
                'ContactId' => $this->contact->getId(),
                'Credit'    => moneyToDecimal($this->bonuses),
                'CharityBonusCard' => $this->charityFoundation->getBonuscard(),
            ]),
            'value'
        );
    }
}

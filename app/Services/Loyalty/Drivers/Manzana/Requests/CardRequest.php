<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Entity\LoyCard;

class CardRequest extends BaseByContactRequest
{
    private const CARD_FILTER_PATH = '/Card/GetAllByContact';
    private const CARD_AVAILABLE_STATUS = 2;

    public function processRequest(): ?LoyCard
    {
        return transform(
            $this->get(
                $this->customerDomain . self::CARD_FILTER_PATH,
                $this->prepareSuperQuery([
                    'contactId' => $this->contact->id,
                ]),
                'value'
            ),
            function (array $card) {
                $cardsFiltered = collect($card)->filter(fn (array $cardInfo) => $cardInfo['StatusCode'] === self::CARD_AVAILABLE_STATUS)
                    ->map(
                        fn (array $cardInfo) => new LoyCard(
                            $cardInfo['Number'],
                            empty($cardInfo['ActiveBalance']) || $cardInfo['ActiveBalance'] <= 1 ? 0 : $cardInfo['ActiveBalance']
                        )
                    );

                return $cardsFiltered->isEmpty() ? null : $cardsFiltered->first();
            }
        );
    }
}

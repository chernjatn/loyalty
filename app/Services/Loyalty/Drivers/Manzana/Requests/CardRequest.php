<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use Illuminate\Support\Collection;
use Ultra\Shop\Enums\LoyCardType;
use App\Entity\LoyCard;

class CardRequest extends BaseByContactRequest
{
    private const CARD_FILTER_PATH     = '/Card/GetAllByContact';
    private const CARD_AVAILABLE_STATUS = 2;

    public function processRequest(): ?Collection
    {
        return transform(
            $this->get(
                $this->customerDomain . self::CARD_FILTER_PATH,
                $this->prepareSuperQuery([
                    'contactId' => $this->contact->getId()
                ]),
                'value'
            ),
            function (array $card) {
                $cardsFiltered = collect($card)->filter(fn (array $cardInfo) => $cardInfo['StatusCode'] == self::CARD_AVAILABLE_STATUS)
                    ->map(
                        fn (array $cardInfo) => new LoyCard(
                            $cardInfo['Number'],
                            //$this->getLoyCardType($cardInfo),
                            empty($cardInfo['ActiveBalance']) || $cardInfo['ActiveBalance'] <= 1 ? null : $cardInfo['ActiveBalance']
                        )
                    );

                return $cardsFiltered->isEmpty() ? null : $cardsFiltered;
            }
        );
    }

    protected function getLoyCardType(array $cardInfo): LoyCardType
    {
        static $partnerLoycardType = null;
        $partnerLoycardType ??= config('manzana.partner_loycard_type');

        return LoyCardType::fromValue($partnerLoycardType[mb_strtoupper($cardInfo['PartnerId'])]);
    }
}

<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO\BonusHistoryItem;

class BonusHistoryRequest extends BaseByContactRequest
{
    private const CHEQUES_PATH  = '/Cheque/GetAllByContact';

    /** @return Collection<BonusHistoryItem> */
    public function processRequest(): ?Collection
    {
        return transform(
            $this->get(
                $this->managerDomain . self::CHEQUES_PATH,
                $this->prepareSuperQuery([
                    'contactId' => $this->contact->getId()
                ]),
                'value'
            ),
            fn (array $response) => collect($response)->map(fn (array $item) => new BonusHistoryItem(
                Carbon::parse($item['Date']),
                __('loyalty.buy_address', ['address' => $item['OrgUnitAddress'] ?: ($item['OrgUnitFullName'] ?: $item['Number'])]),
                transform($item['Summ'] ?: $item['SummDiscounted'], fn ($sum) => moneyFromDecimal($sum)),
                transform($item['PaidByBonus'], fn ($sum) => moneyFromDecimal($sum)),
                transform($item['Bonus'],       fn ($sum) => moneyFromDecimal($sum))
            )),
            fn () => collect()
        );
    }
}

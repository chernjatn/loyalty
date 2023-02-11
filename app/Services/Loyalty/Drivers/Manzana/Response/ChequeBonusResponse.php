<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response;

use Throwable;
use Money\Money;
use Ultra\Shop\Exceptions\LoyaltyException;

class ChequeBonusResponse
{
    protected ?Money $paidByBonus      = null;
    protected ?Money $bonusesReceive   = null;

    public function __construct(SoapResponseRaw $response)
    {
        try {
            $resp = (object) (data_get($response->getResponse(), 'ProcessRequestResult.ChequeResponse.0') ?? throw new LoyaltyException(__('common.error_default')));

            $this->paidByBonus = transform($resp->AvailablePayment ?? null, static fn ($bonuses) => intVal($bonuses) > 0 ? moneyFromDecimal((string) intVal($bonuses)) : null);
            $this->bonusesReceive = transform($resp->ChargedBonus ?? null, static fn ($bonuses) => intVal($bonuses) > 0 ? moneyFromDecimal((string) intVal($bonuses)) : null);
        } catch (Throwable $e) {
            (new LoyaltyException($e->getMessage(), $e->getCode(), $e))->report();
        }
    }

    public function getPaidByBonus(): ?Money
    {
        return $this->paidByBonus;
    }

    public function getBonusesReceive(): ?Money
    {
        return $this->bonusesReceive;
    }
}

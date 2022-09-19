<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\VO;

use Carbon\Carbon;
use Money\Money;
use Ultra\Shop\Contracts\Loyalty\BonusHistoryItem as BonusHistoryItemContract;

class BonusHistoryItem implements BonusHistoryItemContract
{
    private Carbon $date;
    private string $reason;
    private ?Money $amount = null;
    private ?Money $paidByBonus = null;
    private ?Money $bonusesReceive = null;

    public function __construct(Carbon $date, string $reason, ?Money $amount = null, ?Money $paidByBonus = null, ?Money $bonusesReceive = null)
    {
        $this->date           = $date;
        $this->reason         = $reason;
        $this->amount         = $amount;
        $this->paidByBonus    = $paidByBonus;
        $this->bonusesReceive = $bonusesReceive;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getAmount(): ?Money
    {
        return $this->amount;
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

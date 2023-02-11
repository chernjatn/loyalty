<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response;

use Money\Money;
use Ultra\Shop\Services\Prices\Price;

class ChequeResponseItem
{
    private object $data;
    private ?Price $price;
    private ?Price $amount;

    private ?Money $priceRaw;
    private ?Money $priceDiscountedRaw;
    private ?Money $amountRaw;
    private ?Money $amountDiscountedRaw;

    private ?Money $paidByBonus;
    private ?Money $bonusesReceive;

    public function __construct(object $item, float $summ, float $chargedBonus)
    {
        $this->data = $item;
        $this->bonusesReceive = (function () use ($item, $summ, $chargedBonus) {
            if ($item->Summ <= 0 || $summ <= 0 || $chargedBonus <= 0) return null;
            return $this->toMoney(intVal((int)$item->Summ * $chargedBonus / $summ));
        })();
    }

    public function getQuantity(): int
    {
        return (int) $this->data->Quantity;
    }

    public function getPrice(): ?Price
    {
        return $this->price ??= is_null($this->getPriceRaw()) ? null : new Price(
            $this->getPriceRaw(),
            $this->getPriceDiscountedRaw(),
            $this->haveSpecialPrice()
        );
    }

    public function getAmount(): ?Price
    {
        return $this->amount ??= is_null($this->getAmountmRaw()) ? null : new Price(
            $this->getAmountmRaw(),
            $this->getAmountmDiscountedRaw(),
            $this->haveSpecialPrice()
        );
    }

    public function getPriceRaw(): ?Money
    {
        return $this->priceRaw ??= $this->toMoney($this->data->Price ?? null);
    }

    public function getPriceDiscountedRaw(): ?Money
    {
        return $this->priceDiscountedRaw ??= $this->getAmountmDiscountedRaw()?->divide($this->getQuantity());
    }

    public function getAmountmRaw(): ?Money
    {
        return $this->amountRaw ??= $this->toMoney($this->data->Summ ?? null);
    }

    public function getAmountmDiscountedRaw(): ?Money
    {
        return $this->amountDiscountedRaw ??= !$this->haveSpecialPrice() ? null : $this->toMoney($this->data->SummDiscounted ?? null);
    }

    public function haveSpecialPrice(): bool
    {
        return ($this->data->Discount ?? 0) > 0;
    }

    public function getPaidByBonus(): ?Money
    {
        return $this->paidByBonus ??= $this->toMoney($this->data->WriteoffBonus ?? null);
    }

    public function getBonusesReceive(): ?Money
    {
        return $this->bonusesReceive;
    }

    private function toMoney($val): ?Money
    {
        return transform($val, fn ($price) => $val != 0 ? moneyFromDecimal($price) : null);
    }
}

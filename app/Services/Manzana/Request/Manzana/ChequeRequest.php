<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use Money\Money;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Ultra\Shop\Contracts\Checkout\Cart;
use Ultra\Shop\Entities\Store;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response\ChequeBonusResponse;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response\ChequeResponse;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response\SoapResponseRaw;
use Ultra\Shop\Services\Order\OrderItem;
use Ultra\Shop\Services\Order\OrderItemsCollection;
use Ultra\Shop\VO\Coupon;

class ChequeRequest extends SoapRequest
{
    protected const CACHE_TIME = 10;
    protected Cart $cart;
    protected Collection $regularCoupons;
    protected Collection $extendedCoupons;

    private array $chequeRequest = [
        'DateTime'          => null,
        'Organization'      => null,
        'BusinessUnit'      => null,
        'Summ'              => null,
        'SummDiscounted'    => null,
        'PaidByBonus'       => 0,
        'Item'              => [],
        'Discount'          => 0,
        'ChequeType'        => 'Soft',
        'RequestID'         => '2017',
        'Timeout'           => 200,
        'POS'               => 'internetpos',
        'Number'            => 999999999,
        'OperationType'     => 'Sale',
        'ExtendedAttribute' => []
    ];

    protected string $cardNumber;

    public function __construct(OrderItemsCollection $orderItems, Store $fromStore)
    {
        parent::__construct();

        $this->regularCoupons  = new Collection();
        $this->extendedCoupons = new Collection();

        $this->chequeRequest['Organization']   = $fromStore->manzana_brand_id ?: $this->brand;
        $this->chequeRequest['BusinessUnit']   = $fromStore->getGuidRaw();

        $this->chequeRequest['Summ'] = $this->chequeRequest['SummDiscounted'] = moneyToDecimal($orderItems->getItemsAmount()->getBasePrice());

        $orderItems->each(function (OrderItem $orderItem) {
            $this->addItem(
                $orderItem->getSellable()->getArticle(),
                $orderItem->getSellable()->getQuantity(),
                $orderItem->getPrice()->getBasePrice(),
                $orderItem->getAmount()->getBasePrice()
            );
        });
    }

    public function getRegularCoupons(): Collection
    {
        return $this->regularCoupons;
    }

    public function getExtendedCoupons(): Collection
    {
        return $this->extendedCoupons;
    }

    public function processBonusesRequest(): ChequeBonusResponse
    {
        return new ChequeBonusResponse($this->getResponseRaw());
    }

    public function processRequest(): ChequeResponse
    {
        return new ChequeResponse($this, $this->getResponseRaw());
    }

    public function setPaidByBonus(Money $paidByBonus): self
    {
        $this->chequeRequest['PaidByBonus'] = moneyToDecimal($paidByBonus);
        return $this;
    }

    public function setCardNumber(string $cardNumber): self
    {
        transform(
            trim($cardNumber),
            function ($cardNumber) {
                $this->chequeRequest['Card'] = [
                    'CardNumber' => $cardNumber
                ];
            }
        );

        return $this;
    }

    public function setCoupon(Coupon $coupon): self
    {
        (function (Coupon $coupon) {
            if ($this->setExtendedCoupon($coupon)) return;
            $this->setRegularCoupon($coupon);
        })($coupon);

        return $this;
    }

    public function setExtendedAttribute(string $key, $value): self
    {
        $this->chequeRequest['ExtendedAttribute'][] = [
            'Key' => $key,
            'Value' => $value
        ];

        return $this;
    }

    public function setCampain(string $campainKey, $campainValue): self
    {
        $this->setExtendedAttribute($campainKey, $campainValue);

        return $this;
    }

    private function addItem(string $article, int $quantity, Money $price, Money $amount): self
    {
        $summ = moneyToDecimal($amount);

        $this->chequeRequest['Item'][] = [
            'PositionNumber' => count($this->chequeRequest['Item']) + 1,
            'Article'        => $article,
            'Quantity'       => $quantity,
            'Price'          => moneyToDecimal($price),
            'Summ'           => $summ,
            'SummDiscounted' => $summ,
            'Discount'       => 0
        ];

        return $this;
    }

    private function setExtendedCoupon(Coupon $coupon): bool
    {
        if (mb_strlen($coupon->getNumber()) != 13 || !Str::startsWith($coupon->getNumber(), '26')) return false;

        $this->setExtendedAttribute('TEL', $coupon->getNumber());
        $this->extendedCoupons->put($coupon->getNumber(), $coupon);

        return true;
    }

    private function setRegularCoupon(Coupon $coupon): bool
    {
        $this->chequeRequest['Coupons'] = [
            [
                'Number' => $coupon->getNumber()
            ]
        ];
        $this->regularCoupons->put($coupon->getNumber(), $coupon);
        return true;
    }

    private function getResponseRaw(): SoapResponseRaw
    {
        $requestBody = [
            'orgName' => $this->orgName,
            'request' => [
                'ChequeRequest' => $this->chequeRequest
            ]
        ];

        return Cache::remember('loyalty:cheque:' . md5(serialize($requestBody)), self::CACHE_TIME, function () use ($requestBody) {
            $requestBody['request']['ChequeRequest']['DateTime'] = date('c');

            return $this->sendRequest($requestBody);
        });
    }
}

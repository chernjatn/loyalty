<?php

namespace App\Services\Loyalty\Drivers\Manzana;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Enums\LoyaltyType;
use App\Entity\LoyCard;
use App\Services\Loyalty\Drivers\Contracts\LoyaltyDriver;
use App\Entity\Phone;
use App\Entity\Contact;
use App\Entity\LoyaltyCustomer;
use App\DTO\CustomerAddDTO;
use App\Services\Loyalty\Drivers\Manzana\Requests\CardRequest;
use App\Services\Loyalty\Drivers\Manzana\Requests\ContactByPhoneRequest;
use App\Exceptions\Loyalty\LoyaltyException;
use App\Services\Loyalty\Drivers\Manzana\Requests\ContactCreateRequest;
use App\Services\Loyalty\Drivers\Manzana\Requests\LoyCardCreateRequest;
use App\Services\Loyalty\LoyaltyCache;

class ManzanaDriver implements LoyaltyDriver
{
    private LoyaltyType $loyaltyType;

    public function __construct()
    {
        $this->loyaltyType = loyaltyType();
    }

    public function existsCard(Phone $phone): bool
    {
        return (bool) $this->getLoyCardByPhone($phone, true);
    }

    public function getLoyCardByPhone(Phone $phone, bool $useCache = true): ?Collection
    {
        $closure = fn () => transform($this->getLoyaltyCustomerByPhone($phone, $useCache), fn (LoyaltyCustomer $contact) => (new CardRequest($this->loyaltyType, $contact))->processRequest());

        //if (!$useCache) {
        //LoyaltyCache::flushCurrentCustomerCache();
        return $closure();
        // }

        //return LoyaltyCache::rememberCurrentCustomerCache('getloycardsbyphone:' . $phone->getPhoneNumber(), $closure);
    }

    public function getLoyaltyCustomerByPhone(Phone $phone, bool $useCache = true): ?LoyaltyCustomer
    {
        $closure = fn () => (new ContactByPhoneRequest($this->loyaltyType, $phone))->processRequest();
        $key = 'getloyaltycustomerbyphone:' . $phone->getPhoneNumber();

        if (!$useCache) {
            LoyaltyCache::deleteCurrentChannelCache($key);
            return $closure();
        }

        return LoyaltyCache::rememberCurrentChannelCache($key, $closure);
    }

    public function registerLoyCard(CustomerAddDTO $customerAddDTO): LoyCard
    {

        $contact = $this->getContactByPhone($customerAddDTO->getPhone(), false) ?? (new ContactCreateRequest($this->channel, $customerAddDTO))->processRequest();
        if (is_null($contact)) throw new LoyaltyException(__('loyalty.cant_create_contact'));

        $card = (new LoyCardCreateRequest($this->channel, $contact))->processRequest();
        if (is_null($card)) throw new LoyaltyException(__('loyalty.cant_create_contact'));

        LoyaltyCache::flushCurrentCustomerCache();

        return $card;
    }

    private function getContactByPhone(Phone $phone, bool $useCache = true)
    {
        $closure = fn () => (new ContactByPhoneRequest($this->loyaltyType, $phone))->processRequest();

        if (!$useCache) {
            LoyaltyCache::deleteCurrentChannelCache($phone->getPhoneNumber());
            return $closure();
        }

        return LoyaltyCache::rememberCurrentChannelCache('getcontactbyphone:' . $phone->getPhoneNumber(), $closure);
    }

//    public function getBonusesForProduct(Product $product, Price $price): ?Money
//    {
//        static $minPrice = null;
//        $minPrice = money(100_00);
//
//        if ($price->getBasePrice()->lessThan($minPrice)) return null;
//
//        return $price->getBasePrice()->divide(100)->roundToUnit(2)->multiply(5);
//    }
//
//    public function getBonusesWritable(
//        OrderItemsCollection $orderItems,
//        ?Store $fromStore = null,
//        ?Phone $phone = null,
//        ?LoyCard $loyCard = null,
//        ?Money $paidByBonus = null,
//        ?Coupon $coupon = null,
//        ?DeliveryMethod $deliveryMethod = null
//    ): ?Money {
//        if (is_null($fromStore) || is_null($phone) || $orderItems->isEmpty()) return null;
//
//        return transformEx(
//            $this->makeChequeRequest(
//                $orderItems,
//                $fromStore,
//                $phone,
//                $loyCard,
//                money(100000000),
//                $coupon,
//                $deliveryMethod
//            )->processBonusesRequest()->getPaidByBonus(),
//            fn (Money $bonuses) => $this->convertBonusesTo($bonuses)->roundToUnit(2)
//        );
//    }

//    public function calculate(
//        OrderItemsCollection $orderItems,
//        ?Store $fromStore = null,
//        ?Phone $phone = null,
//        ?LoyCard $loyCard = null,
//        ?Money $paidByBonus = null,
//        ?Coupon $coupon = null,
//        ?DeliveryMethod $deliveryMethod = null
//    ): ?LoyaltyCalculateResult {
//        if ($orderItems->isEmpty()) return null;
//
//        if (is_null($fromStore)) {
//            return new LoyaltyCalculateResult('', $orderItems);
//        }
//
//        $chequeResponse = $this->makeChequeRequest(
//            $orderItems,
//            $fromStore,
//            $phone,
//            $loyCard,
//            $paidByBonus,
//            $coupon,
//            $deliveryMethod
//        )->processRequest();
//
//        if ($chequeResponse->isError()) throw new LoyaltyException($chequeResponse->getError());
//
//        $newOrderItems = $orderItems
//            ->map(function (OrderItem $orderItem) use ($chequeResponse) {
//                $newOrderItem = (clone $orderItem);
//                transform(
//                    $chequeResponse->getItem($orderItem),
//                    function (ChequeResponseItem $chequeResponseItem) use ($newOrderItem) {
//                        transform(
//                            $chequeResponseItem->getPrice(),
//                            fn (Price $price)  => $newOrderItem->setPrice($price)
//                        );
//
//                        transform(
//                            $chequeResponseItem->getAmount(),
//                            fn (Price $price)  => $newOrderItem->setAmount(
//                                is_null($chequeResponseItem->getPaidByBonus())
//                                    ? $price
//                                    : $price->toMutable()->subtractSpecialPrice($this->convertBonusesFrom($chequeResponseItem->getPaidByBonus()))->toImmutable()
//                            )
//                        );
//
//                        transform(
//                            $chequeResponseItem->getBonusesReceive(),
//                            fn (Money $price) => $newOrderItem->setBonusesReceive($price)
//                        );
//
//                        transform(
//                            $chequeResponseItem->getPaidByBonus(),
//                            fn (Money $price) => $newOrderItem->setPaidByBonus($price)
//                        );
//                    }
//                );
//                return $newOrderItem;
//            });
//
//        return new LoyaltyCalculateResult(
//            $chequeResponse->getResponse()->getResponseRaw(),
//            $newOrderItems,
//            $chequeResponse->getPaidByBonus(),
//            $chequeResponse->getBonusesReceive(),
//            $chequeResponse->getCoupons()
//        );
//    }
//
//    public function getBonusHistory(HasBonuses $hasBonuses): Collection
//    {
//        return LoyaltyCache::rememberCurrentCustomerCache(
//            'getbonushistory:' . $hasBonuses->getPhoneAttribute()->getPhoneNumber(),
//            fn () => transform(
//                $this->getContactByPhone($hasBonuses->getPhoneAttribute()),
//                fn (Contact $contact) => (new BonusHistoryRequest($this->channel, $contact))->processRequest()
//            )
//        );
//    }
//
//    public function verifyPhone(HasBonuses $hasBonuses): bool
//    {
//        $contact = $this->getContactByPhone($hasBonuses->getPhoneAttribute());
//        if (is_null($contact)) return false;
//
//        return (new ContactUpdateRequest($contact))->processRequest();
//    }
//
//    public function verifyEmail(string $email): bool
//    {
//        $contact = $this->getContactByEmail($email);
//        if (is_null($contact)) return false;
//
//        $eamanager = new ExtendedAttributesManager($this->channel, $contact);
//        return $eamanager->bind('AddEmail+verified', new EADateTimeValue(Carbon::now()));
//    }
//
//    private function makeChequeRequest(
//        OrderItemsCollection $orderItems,
//        Store $fromStore,
//        ?Phone $phone = null,
//        ?LoyCard $loyCard = null,
//        ?Money $paidByBonus = null,
//        ?Coupon $coupon = null,
//        ?DeliveryMethod $deliveryMethod = null
//    ): ChequeRequest {
//        $config = $this->getChannelConfig();
//        $chequeRequest = new ChequeRequest($orderItems, $fromStore);
//
//        if (is_null($loyCard) && !is_null($phone)) {
//            $loyCard = $this->getLoyCardsByPhone($phone)?->first();
//        }
//
//        if (!is_null($loyCard)) {
//            $chequeRequest->setCardNumber($loyCard->getNumber());
//        } else {
//            $chequeRequest->setCardNumber($config['loy_card_default_auth']);
//        }
//
//        if (!is_null($paidByBonus)) {
//            $chequeRequest->setPaidByBonus($this->calcBonusesWritable($paidByBonus, $this->calcOrderAmount($orderItems)));
//        }
//
//        if (!is_null($coupon)) {
//            $chequeRequest->setCoupon($coupon);
//        }
//
//        collect($config['extended']['common'])
//            ->each(function ($val, $key) use ($chequeRequest) {
//                $chequeRequest->setExtendedAttribute($key, $val);
//            });
//
//        if (!is_null($deliveryMethod)) {
//            if ($deliveryMethod->isCourier()) {
//                collect($config['extended']['delivery'])
//                    ->each(function ($val, $key) use ($chequeRequest) {
//                        $chequeRequest->setExtendedAttribute($key, $val);
//                    });
//            }
//
//            if ($deliveryMethod->isPickup()) {
//                collect($config['extended']['pickup'])
//                    ->each(function ($val, $key) use ($chequeRequest) {
//                        $chequeRequest->setExtendedAttribute($key, $val);
//                    });
//            }
//        }
//
//        transform(
//            analyticsBag()->get()['utm_term'] ?? null,
//            function ($utmTerms) use ($chequeRequest, &$config) {
//                $utmCampaign = analyticsBag()->get()['utm_campaign'] ?? $config['default_utm_campaign'];
//
//                foreach (explode(',', $utmTerms) as $utmTerm) {
//                    $chequeRequest->setCampain($utmTerm, $utmCampaign);
//                }
//            }
//        );
//
//        return $chequeRequest;
//    }
//
//
//    private function getContactByEmail(string $email, bool $useCache = true): ?Contact
//    {
//        $closure = fn () => (new ContactByEmailRequest($this->channel, $email))->processRequest();
//
//        if (!$useCache) {
//            LoyaltyCache::deleteCurrentChannelCache($email);
//            return $closure();
//        }
//
//        return LoyaltyCache::rememberCurrentChannelCache('getcontactbyemail:' . $email, $closure);
//    }
//
//    private function convertBonusesTo(Money $money): Money
//    {
//        // if ($this->channel->isOzerki()) {
//        //     $money = $money->multiply(10);
//        // }
//
//        return $money;
//    }
//
//    private function convertBonusesFrom(Money $money): Money
//    {
//        if ($this->channel->isOzerki()) {
//            $money = $money->divide(10);
//        }
//
//        return $money;
//    }
//
//    private function calcOrderAmount(Collection $orderItems): Money
//    {
//        return $orderItems->reduce(fn (Money $carry, OrderItem $orderItem) => $carry->add($orderItem->getAmount()->getBasePrice()), money(0));
//    }
//
//    private function calcBonusesWritable(Money $paidByBonus, Money $orderAmount): Money
//    {
//        $maxBonusAmount = $orderAmount->subtract(money(self::ORDER_MIN_PRICE));
//
//        return $paidByBonus->lessThan($maxBonusAmount) ? $paidByBonus : $maxBonusAmount;
//    }

    private function getChannelConfig(): array
    {
        return config('manzana.channels.' . $this->channel->getCode());
    }
}

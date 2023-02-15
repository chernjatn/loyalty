<?php

namespace App\Services\Loyalty\Drivers\Manzana;

use Illuminate\Support\Collection;
use App\Enums\LoyaltyType;
use App\Entity\LoyCard;
use App\Services\Loyalty\Drivers\Contracts\LoyaltyDriver;
use App\Entity\Phone;
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
        dd($this->getContactByPhone($phone, false));
        return (bool) $this->getLoyCardByPhone($phone, true);
    }

    public function getLoyCardByPhone(Phone $phone, bool $useCache = true): ?Collection
    {
        $closure = fn () => transform($this->getLoyaltyCustomerByPhone($phone, $useCache), fn (LoyaltyCustomer $contact) => (new CardRequest($this->loyaltyType, $contact))->processRequest());

        if (!$useCache) {
            LoyaltyCache::flushCurrentCustomerCache();
            return $closure();
        }

        return LoyaltyCache::rememberCurrentCustomerCache('getloycardsbyphone:' . $phone->getPhoneNumber(), $closure);
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
        $contact = $this->getContactByPhone($customerAddDTO->getPhone(), false) ?? (new ContactCreateRequest($this->loyaltyType, $customerAddDTO))->processRequest();
        if (is_null($contact)) throw new LoyaltyException(__('loyalty.cant_create_contact'));

        $card = (new LoyCardCreateRequest($this->loyaltyType, $contact))->processRequest();
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

//    private function getChannelConfig(): array
//    {
//        return config('manzana.channels.' . $this->loyaltyType->value);
//    }
}

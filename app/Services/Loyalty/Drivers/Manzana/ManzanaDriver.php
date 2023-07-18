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
use App\Services\Loyalty\Exceptions\LoyaltyException;
use App\Services\Loyalty\Drivers\Manzana\Requests\ContactCreateRequest;
use App\Services\Loyalty\Drivers\Manzana\Requests\ContactUpdateRequest;
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
            LoyaltyCache::deleteCurrentLoyaltyCache($key);
            return $closure();
        }

        return LoyaltyCache::rememberCurrentLoyaltyCache($key, $closure);
    }

    public function registerLoyCard(CustomerAddDTO $customerAddDTO): LoyCard
    {
        $contact = (function () use ($customerAddDTO) {
            $contact = $this->getContactByPhone($customerAddDTO->getPhone(), false);
            if (!is_null($contact)) {
                $fields = get_object_vars($contact);
                unset($fields['id']);

                if ($customerAddDTO == new CustomerAddDTO($fields)) {
                    return $contact;
                }

                return (new ContactUpdateRequest($this->loyaltyType, $customerAddDTO, $contact->id))->processRequest();
            }

            return (new ContactCreateRequest($this->loyaltyType, $customerAddDTO))->processRequest();
        })();

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
            LoyaltyCache::deleteCurrentLoyaltyCache($phone->getPhoneNumber());
            return $closure();
        }

        return LoyaltyCache::rememberCurrentLoyaltyCache('getcontactbyphone:' . $phone->getPhoneNumber(), $closure);
    }
}

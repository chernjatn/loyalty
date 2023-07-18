<?php

namespace App\Services\Loyalty;

use Closure;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;
use App\Entity\Phone;

class LoyaltyCache
{
    private const CUSTOMER = 'loyalty:current_customer_by_phone';
    private const LOYALTY = 'loyalty:current_loyalty_type';

    public static function getCurrentCustomerCache(Phone $phone): TaggedCache
    {
        return Cache::tags([self::CUSTOMER . $phone->getPhoneNumber()]);
    }

    public static function getCurrentLoyaltyCache(): TaggedCache
    {
        return Cache::tags([self::LOYALTY . ':' . loyaltyType()->value]);
    }

    public static function rememberCurrentCustomerCache(string $key, Phone $phone, Closure $closure, $ttl = 300)
    {
        return self::getCurrentCustomerCache($phone)->remember(self::makeKey($key), $ttl, $closure);
    }

    public static function rememberCurrentLoyaltyCache(string $key, Closure $closure, $ttl = 300)
    {
        return self::getCurrentLoyaltyCache()->remember(self::makeKey($key), $ttl, $closure);
    }

    public static function flushCurrentCustomerCache(Phone $phone)
    {
        self::getCurrentCustomerCache($phone)->flush();
    }

    public static function deleteCurrentLoyaltyCache(string $key)
    {
        return self::getCurrentLoyaltyCache()->delete(self::makeKey($key));
    }

    private static function makeKey(string $key): string
    {
        return loyaltyType()->value . ':' . $key;
    }
}

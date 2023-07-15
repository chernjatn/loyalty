<?php

namespace App\Services\Loyalty;

use App\Enums\LoyaltyType;
use Closure;
use Illuminate\Cache\NullStore;
use Illuminate\Cache\TaggedCache;
use Illuminate\Cache\TagSet;
use Illuminate\Support\Facades\Cache;

class LoyaltyCache
{
    private const CUSTOMER = 'loyalty:current_customer';
    private const CHANNEL  = 'loyalty:current_channel';

    public static function getCurrentCustomerCache(): TaggedCache
    {
        return Cache::tags([self::CUSTOMER]);
    }

    public static function getCurrentLoyaltyCache(): TaggedCache
    {
        return Cache::tags([self::CHANNEL . ':' . loyaltyType()->value]);
    }

    public static function rememberCurrentCustomerCache(string $key, Closure $closure, $ttl = 300)
    {
        return self::getCurrentCustomerCache()->remember(self::makeKey($key), $ttl, $closure);
    }

    public static function rememberCurrentLoyaltyCache(string $key, Closure $closure, $ttl = 300)
    {
        return self::getCurrentLoyaltyCache()->remember(self::makeKey($key), $ttl, $closure);
    }

    public static function flushCurrentCustomerCache()
    {
        self::getCurrentCustomerCache()->flush();
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

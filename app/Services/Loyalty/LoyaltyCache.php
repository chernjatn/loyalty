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
        return Cache::tags([self::CUSTOMER . ':' . session()->getId()]);
    }

    public static function getCurrentChannelCache(): TaggedCache
    {
        return Cache::tags([self::CHANNEL . ':' . loyaltyType()->value]);
    }

    public static function rememberCurrentCustomerCache(string $key, Closure $closure, $ttl = 300)
    {
        return self::getCurrentCustomerCache()->remember(self::makeKey($key), $ttl, $closure);
    }

    public static function rememberCurrentChannelCache(string $key, Closure $closure, $ttl = 300)
    {
        return self::getCurrentChannelCache()->remember(self::makeKey($key), $ttl, $closure);
    }

    public static function flushCurrentCustomerCache()
    {
        self::getCurrentCustomerCache()->flush();
    }

    public static function deleteCurrentChannelCache(string $key)
    {
        return self::getCurrentChannelCache()->delete(self::makeKey($key));
    }

    private static function makeKey(string $key): string
    {
        return request('channel_code', '0') . ':' . $key;
    }

    private static function makeNullCache()
    {
        static $nullCache = null;

        return $nullCache ??= new TaggedCache(new NullStore(), new TagSet(new NullStore()));
    }
}

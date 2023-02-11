<?php

namespace App\Ecom;

use App\Enums\LoyaltyType;
use App\Ecom\Ecom;

class Connection
{
    private static array $connection = [];

    public static function getConnection(LoyaltyType $loyalType): Ecom
    {
        return self::$connection[$loyalType->value] ??= (function () use ($loyalType) {
            $config = config('ecom');
            return new Ecom($config['url'], $config['login'], $config['password']);
        })();
    }

//    private static function getChannelConfig(LoyaltyType $loyalType): array
//    {
//        $config = config('ecom.channels.' . $loyalType->key);
//        if (empty($config)) throw new \Exception('No config for ' . $loyalType->key);
//        return $config;
//    }
}

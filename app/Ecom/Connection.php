<?php

namespace App\Ecom;

class Connection
{
    private static $connection = null;

    public static function getConnection(): Ecom
    {
        $config = config('ecom');

        return self::$connection ??= new Ecom($config['url'], $config['login'], $config['password']);
    }
}

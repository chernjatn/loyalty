<?php

return [
    'debug'   => env('SMS_DEBUG', false), //log
    'default' => 'superapteka',
    'drivers' => [
        'superapteka' => [
            'loyaltyType' => 2
        ],
        'ozerki' => [
            'loyaltyType' => 1
        ],
    ],
    'map' => [
        'superapteka' => \App\Services\Sms\Drivers\EcomSmsDriver::class,
        'ozerki'      => \App\Services\Sms\Drivers\EcomSmsDriver::class,
    ]
];

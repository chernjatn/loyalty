<?php

use Ultra\Shop\Enums\LoyCardType;
//use Ultra\Shop\Enums\Order\DeliveryMethodType;
//use Ultra\Shop\Enums\Order\OrderPaymentStatus;
//use Ultra\Shop\Enums\Order\OrderStatus;
//use Ultra\Shop\Enums\Order\PaysystemType;

return [
//    'token'    => '40f8c91e-c1fc-48e4-8e59-8690f669b793',
//    'token-py' => '9ffc0483-1bda-458e-8af6-75f16e888bbb',
//    'token-or' => '89EFD759A3DD5ABA695ACF4C5500C90BACBC6A42330AD1EE8EBB86E39FC4E77D',
//    'debug' => env('ECOM_DEBUG', true),
//    'ftp' => [
//        'host'      => env('ECOM_FTP_HOST',     ''),
//        'username'  => env('ECOM_FTP_USERNAME', ''),
//        'password'  => env('ECOM_FTP_PASSWORD', ''),
//        'port'      => env('ECOM_FTP_PORT',     '21'),
//        'timeout'   => env('ECOM_FTP_TIMEOUT',  '10'),
//    ],
//    'channels' => [
//        'superapteka' => [
//            'free_delivery'       => [
//                'min_cart_amount' => 3_000_00,
//                'no_timeslot'     => [39]
//            ],
            'url'                 => env('ECOM_CHANNEL_SUPERAPTEKA_URL', ''),
            'login'               => env('ECOM_CHANNEL_SUPERAPTEKA_LOGIN', ''),
            'password'            => env('ECOM_CHANNEL_SUPERAPTEKA_PASSWORD', '')
//        ],
//        'express' => [
//            'free_delivery'       => [
//                'min_cart_amount' => 3_000_00,
//                'no_timeslot'     => [39]
//            ],
//            'url'                 => env('ECOM_CHANNEL_EX_SUPERAPTEKA_URL', ''),
//            'login'               => env('ECOM_CHANNEL_EX_SUPERAPTEKA_LOGIN', ''),
//            'password'            => env('ECOM_CHANNEL_EX_SUPERAPTEKA_PASSWORD', '')
//        ],
//        'ozerki' => [
//            'free_delivery'       => [
//                'min_cart_amount' => 3_000_00,
//                'no_timeslot'     => [39]
//            ],
//            'url'                 => env('ECOM_CHANNEL_OZERKI_URL', ''),
//            'login'               => env('ECOM_CHANNEL_OZERKI_LOGIN', ''),
//            'password'            => env('ECOM_CHANNEL_OZERKI_PASSWORD', '')
//        ],
//    ],
//    'order_prefix' => env('ECOM_ORDER_PREFIX', ''),
//    'paysystems' => [
//        PaysystemType::CASH         => 3,
//        PaysystemType::CASH_COURIER => 4,
//        PaysystemType::ONLINE       => 1,
//    ],
//    'loycards' => [
//        LoyCardType::ZOZ         => 1,
//        LoyCardType::SUPERSAMSON => 2,
//        LoyCardType::YA_BUDU_JIT => 3,
//        LoyCardType::SUPERAPTEKA => 4,
//        LoyCardType::APTEKA_RU   => 7,
//    ],
//    'to_statuses' => [
//        OrderStatus::WAIT_PAYMENT       => 56,
//        OrderStatus::WAIT_DARKSTORE     => 26,
//        OrderStatus::CANCELED           => 15,
//        OrderStatus::CANCELED_BY_STORE  => 13,
//    ],
//    'to_filter_statuses' => [
//        OrderStatus::CREATED            => [9],
//        OrderStatus::WAIT_DARKSTORE     => [26],
//        OrderStatus::WAIT_PAYMENT       => [56, 57],
//        OrderStatus::PICKUPABLE         => [10, 11],
//        OrderStatus::ASSEMBLY           => [10, 11],
//        OrderStatus::PICKUPED           => [12],
//        OrderStatus::CANCELED           => [13, 19],
//        OrderStatus::CANCELED_BY_STORE  => [14, 15],
//        OrderStatus::DELIVERING         => [48],
//    ],
//    'from_statuses' => [
//        DeliveryMethodType::PICKUP => [
//            9  => OrderStatus::CREATED,
//
//            26 => OrderStatus::WAIT_DARKSTORE,
//
//            56 => OrderStatus::WAIT_PAYMENT,
//            57 => OrderStatus::WAIT_PAYMENT,
//
//            10 => OrderStatus::PICKUPABLE,
//            11 => OrderStatus::PICKUPABLE,
//
//            12 => OrderStatus::PICKUPED,
//
//            13 => OrderStatus::CANCELED,
//            14 => OrderStatus::CANCELED_BY_STORE,
//            15 => OrderStatus::CANCELED_BY_STORE,
//            19 => OrderStatus::CANCELED,
//        ],
//
//        DeliveryMethodType::COURIER => [
//            9  => OrderStatus::CREATED,
//
//            26 => OrderStatus::WAIT_DARKSTORE,
//
//            56 => OrderStatus::WAIT_PAYMENT,
//            57 => OrderStatus::WAIT_PAYMENT,
//
//            10 => OrderStatus::ASSEMBLY,
//            11 => OrderStatus::ASSEMBLY,
//            48 => OrderStatus::DELIVERING,
//
//            12 => OrderStatus::PICKUPED,
//
//            13 => OrderStatus::CANCELED,
//            14 => OrderStatus::CANCELED_BY_STORE,
//            15 => OrderStatus::CANCELED_BY_STORE,
//            19 => OrderStatus::CANCELED,
//        ],
//    ],
//    'payment' => [
//        OrderPaymentStatus::PAYED => 58
//    ]
];

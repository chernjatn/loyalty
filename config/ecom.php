<?php

return [
    'token' => '40f8c91e-c1fc-48e4-8e59-8690f669b793',
    'token-py' => '9ffc0483-1bda-458e-8af6-75f16e888bbb',
    'token-or' => '89EFD759A3DD5ABA695ACF4C5500C90BACBC6A42330AD1EE8EBB86E39FC4E77D',
    'debug' => env('ECOM_DEBUG', true),
    'ftp' => [
        'host' => env('ECOM_FTP_HOST', ''),
        'username' => env('ECOM_FTP_USERNAME', ''),
        'password' => env('ECOM_FTP_PASSWORD', ''),
        'port' => env('ECOM_FTP_PORT', '21'),
        'timeout' => env('ECOM_FTP_TIMEOUT', '10'),
    ],

    'url' => env('ECOM_CHANNEL_SUPERAPTEKA_URL', ''),
    'login' => env('ECOM_CHANNEL_SUPERAPTEKA_LOGIN', ''),
    'password' => env('ECOM_CHANNEL_SUPERAPTEKA_PASSWORD', '')
];

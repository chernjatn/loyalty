<?php

namespace App\Services\Sms;

use Tzsk\Sms\Sms as BaseSms;

class SmsManager extends BaseSms
{
    public function __construct()
    {
        $config = config('sms');
        $config['default'] = loyaltyType()->key ?? $config['default'];
        parent::__construct($config);
    }
}

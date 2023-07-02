<?php

namespace App\Services\Sms;

use Tzsk\Sms\Sms as BaseSms;

class SmsManager extends BaseSms
{
    public function __construct($channel = null)
    {
        $config = config('sms');
        $config['default'] = $channel->code ?? $config['default'];
        parent::__construct($config);
    }
}

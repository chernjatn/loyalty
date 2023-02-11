<?php

namespace App\Services\Sms;

use Tzsk\Sms\Sms as BaseSms;
//use Ultra\Shop\Contracts\Common\RequestDepends;
//use Webkul\Core\Models\Channel;

class SmsManager extends BaseSms
{
    public function __construct($channel = null)
    {
        $config = config('sms');
        $config['default'] = $channel->code ?? $config['default'];
        parent::__construct($config);
    }
}

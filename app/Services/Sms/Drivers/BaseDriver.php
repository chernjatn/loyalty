<?php

namespace App\Services\Sms\Drivers;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface as Logger;
use Tzsk\Sms\Contracts\Driver;

abstract class BaseDriver extends Driver
{
    protected Logger $logger;
    protected bool $isDebug;

    public function __construct()
    {
        $this->isDebug = config('sms.debug');
        $this->logger = Log::channel('sms');
    }

    abstract public function send();
}

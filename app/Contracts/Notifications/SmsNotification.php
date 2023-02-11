<?php

namespace App\Contracts\Notifications;

use Webkul\Core\Models\Channel;

interface SmsNotification
{
    public function toSms(): string;
}

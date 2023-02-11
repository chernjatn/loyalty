<?php

namespace App\Contracts\Notifications;

use App\Entity\Phone;

interface SmsNotifiable
{
    public function getId(): string;
    public function getPhoneAttribute(): Phone;
    public function notify($instance);
    public function notifyNow($instance, array $channels = null);
}

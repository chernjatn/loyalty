<?php

namespace App\Services\Sms;

use App\Entity\Phone;
use Illuminate\Notifications\RoutesNotifications;

class SmsNotifiable
{
    use RoutesNotifications;

    protected string $id;
    protected Phone $phone;

    public function __construct(string $id, Phone $phone = null)
    {
        $this->id = $id;
        $this->phone = $phone;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPhoneAttribute(): Phone
    {
        return $this->phone;
    }
}

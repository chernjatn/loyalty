<?php

namespace App\Exceptions\Loyalty;

class ThrottleException extends \Exception
{
    public function __construct(int $availableInSeconds, string $message = '')
    {
        parent::__construct($message ?: __('validation.custom.too_many_attempts', ['seconds' => $availableInSeconds]));
    }
}

<?php

namespace Ultra\Shop\Exceptions\Sms;

use Ultra\Shop\Exceptions\BadRequestException;

class SmsVerificationException extends BadRequestException
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: __('validation.custom.sms_verification_wrong'));
    }
}

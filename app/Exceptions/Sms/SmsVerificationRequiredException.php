<?php

namespace Ultra\Shop\Exceptions\Sms;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Ultra\API\Resources\Date\DateTimeResource;
use Ultra\Shop\Exceptions\BadRequestException;

class SmsVerificationRequiredException extends BadRequestException
{
    public function __construct(Carbon $expires, string $message = '')
    {
        parent::__construct($message ?: __('validation.custom.sms_verification_code'), Response::HTTP_OK);
        $this->data = [
            'smsVerificationCode' => [
                'sended' => true,
                'expires' => new DateTimeResource($expires),
            ]
        ];
    }
}

<?php

namespace Ultra\Shop\Exceptions\Sms;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Ultra\API\Resources\Date\DateTimeResource;
use Ultra\Shop\Exceptions\BadRequestException;

class SmsVerificationTokenRequiredException extends BadRequestException
{
    public function __construct(string $token, Carbon $expires, string $message = '')
    {
        parent::__construct($message ?: __('validation.custom.sms_verification_token'), Response::HTTP_OK);
        $this->data = [
            'smsVerificationToken' => [
                'value'   => $token,
                'expires' => new DateTimeResource($expires),
            ]
        ];
    }
}

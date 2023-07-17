<?php

namespace App\Services\Cache\Exceptions;

use Carbon\Carbon;
use App\Exceptions\BadRequestException;

class ActionRepeatedException extends BadRequestException
{
    public function __construct(string $message, Carbon $lastActionTime)
    {
        $message = __($message, ['seconds' => Carbon::now()->diffInSeconds($lastActionTime)]);

        parent::__construct(__($message));
    }
}

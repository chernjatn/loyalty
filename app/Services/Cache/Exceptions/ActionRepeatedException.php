<?php

namespace App\Services\Cache\Exceptions;

use Carbon\Carbon;
use App\Exceptions\BadRequestException;

class ActionRepeatedException extends BadRequestException
{
    public function __construct(string $messageId, Carbon $lastActionTime)
    {
        $message = __($messageId, ['date' => $lastActionTime->isoFormat('D MMMM YYYY'), 'time' => $lastActionTime->format('H:i')]);

        parent::__construct(__($message));
    }
}

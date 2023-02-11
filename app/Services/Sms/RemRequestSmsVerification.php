<?php

namespace App\Services\Sms;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ultra\Shop\Exceptions\Sms\SmsVerificationTokenRequiredException;
use Ultra\Shop\Services\Common\RateLimiter;

/**
 * @deprecated не используется
 */
class RemRequestSmsVerification extends RequestSmsVerification
{
    private const REM_TOKEN_TTL = 120;

    public function validate(Request $request): void
    {
        if ($request->has('verificationToken')) {
            $this->throttle($this->getIpLimiterVerifyToken($request));

            [$ttl, $token] = $this->customerManager->getSession($this->getSessKey()) ?? [null, null];

            if (isset($ttl, $token) && $ttl > time() && $token === $request->input('verificationToken')) {
                return;
            }
        }

        parent::validate($request);
    }

    public function verify(Request $request): bool
    {
        if (!parent::verify($request)) {
            return false;
        }

        $token = (string) Str::uuid();
        $expires = Carbon::now()->addSeconds(self::REM_TOKEN_TTL);

        $this->customerManager->setSession($this->getSessKey(), [$expires->getTimestamp(), $token]);

        throw new SmsVerificationTokenRequiredException($token, $expires);
    }

    private function getIpLimiterVerifyToken(Request $request): RateLimiter
    {
        return new RateLimiter($this->getSessKey() . ':' . md5($request->ip() ?? 'undefined'), self::MAX_IP_ATTEMPTS_VERIFY, self::DECAY_SECONDS_VERIFY);
    }

    private function getSessKey()
    {
        return 'requestsms:verif-token:' . $this->key;
    }
}

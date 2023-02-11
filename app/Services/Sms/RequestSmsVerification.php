<?php

namespace Ultra\Shop\Services\Sms;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Ultra\API\Requests\SmsVerificationRequest;
use Ultra\Shop\Exceptions\Sms\SmsVerificationException;
use Ultra\Shop\Exceptions\Sms\SmsVerificationRequiredException;
use Ultra\Shop\Exceptions\ThrottleException;
use Ultra\Shop\Services\Common\RateLimiter;
use Ultra\Shop\Services\Customer\CustomerManager;
use Ultra\Shop\VO\Phone;

/**
 * @deprecated не используется
 */
class RequestSmsVerification
{
    protected const MAX_IP_ATTEMPTS_GEN    = 3;
    protected const DECAY_SECONDS_GEN      = 120;
    protected const MAX_IP_ATTEMPTS_VERIFY = 10;
    protected const DECAY_SECONDS_VERIFY   = 120;

    protected CustomerManager $customerManager;
    protected SmsVerification $smsVerification;

    /** @param string $key - уникальный ключ операции(прим. create_user, create_order) */
    public function __construct(
        protected Phone $phone,
        protected string $key,
        protected ?string $preamble = null,
    ) {
        $this->customerManager = customer();
        $this->smsVerification = new SmsVerification(new SmsNotifiable($this->customerManager->getSessionId(), $this->phone), $this->key, $preamble);
    }

    public function validate(Request $request): void
    {
        if (!$request->has('verificationCode')) {
            throw new SmsVerificationRequiredException($this->gen($request));
        }

        if (!$this->verify($request)) throw new SmsVerificationException();
    }

    public function gen(Request $request): Carbon
    {
        $this->throttle($this->getIpLimiterGen($request));

        return $this->smsVerification->gen();
    }

    public function verify(Request $request): bool
    {
        $this->throttle($this->getIpLimiterVerify($request));

        return $this->smsVerification->verify(app(SmsVerificationRequest::class)->getVerificationCode());
    }

    /** @throws */
    protected function throttle(RateLimiter $rateLimiter): void
    {
        if ($rateLimiter->tooManyAttempts()) throw new ThrottleException($rateLimiter->availableIn());
        $rateLimiter->hit();
    }

    protected function getIpLimiterGen(Request $request): RateLimiter
    {
        return new RateLimiter('requestsms:gen:' . md5($request->ip() ?? 'undefined'), self::MAX_IP_ATTEMPTS_GEN, self::DECAY_SECONDS_GEN);
    }

    protected function getIpLimiterVerify(Request $request): RateLimiter
    {
        return new RateLimiter('requestsms:verif:' . md5($request->ip() ?? 'undefined'), self::MAX_IP_ATTEMPTS_VERIFY, self::DECAY_SECONDS_VERIFY);
    }
}

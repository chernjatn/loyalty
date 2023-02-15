<?php

namespace App\Services\Sms;

use Carbon\Carbon;
use Illuminate\Redis\Connections\PhpRedisConnection;
use App\Services\Common\RateLimiter;
use mysql_xdevapi\Exception;
use Tzsk\Sms\Sms as BaseSms;
use Illuminate\Support\Facades\Redis;

class NotificationService
{
    protected const DB                       = 'data';
    protected const KEY_EXP                  = 600;

    protected const MAX_VERIFY_ATTEMPTS      = 5;
    protected const VERIFY_DECAY_SECONDS     = 60;

    protected const MAX_GET_ATTEMPTS         = 1;   //одна смс
    protected const GET_DECAY_SECONDS        = 60;  //раз в минуту
    protected const MAX_GET_SUM_ATTEMPTS     = 3;   //после трех попыток
    protected const GET_SUM_DECAY_SECONDS    = 1800; //требуем капчу в течении 3х часов

    protected PhpRedisConnection $connection;
    protected BaseSms $smsManager;
    protected RateLimiter $verifyLimiter;
    protected RateLimiter $genLimiter;
    protected RateLimiter $getSumLimiter;
    protected bool $isDebug;

    public function __construct(
        protected SmsNotifiable $smsNotifiable,
        protected ?string $preamble = null,
    ) {
        $this->smsManager       = new smsManager();
        $this->key              = $this->keyGenerate($this->smsNotifiable);
        $this->connection       = Redis::connection(self::DB);
        $this->verifyLimiter    = new RateLimiter($this->key . ':verify', self::MAX_VERIFY_ATTEMPTS, self::VERIFY_DECAY_SECONDS);
        $this->genLimiter       = new RateLimiter($this->key . ':gen', self::MAX_GET_ATTEMPTS, self::GET_DECAY_SECONDS);
        $this->getSumLimiter    = new RateLimiter($this->key . ':verifysum', self::MAX_GET_SUM_ATTEMPTS, self::GET_SUM_DECAY_SECONDS);
        $this->noCaptcha        = app('captcha');
        $this->isDebug          = config('sms.debug') && config('app.debug');
    }

    /**
     * проверяет код из смс
     * !проблема с запоздалыми смс из за KEY_EXP
     */
    public function verify(string $verificationKey): bool
    {
        if ($this->verifyLimiter->tooManyAttempts()) {
            $this->connection->del($this->key);
            throw new Exception($this->verifyLimiter->availableIn());
        }

        if ($this->connection->get($this->key) == $verificationKey) {
            $this->verifyLimiter->clear();
            $this->connection->del($this->key);
            return true;
        }

        $this->verifyLimiter->hit();
        return false;
    }

    /**
     * Отправяле смс
     * @return Carbon - expiration time
     */
    public function gen(): Carbon
    {
        if ($this->genLimiter->tooManyAttempts()) throw new Exception($this->genLimiter->availableIn());

        $verificationCode = $this->genVerificationCode();
        $dateTo = Carbon::now()->addSeconds(self::KEY_EXP);

        $this->connection->set($this->key, $verificationCode, 'EX', self::KEY_EXP);
        $this->smsManager->to($this->smsNotifiable->getPhoneAttribute())->send('code:' . $verificationCode);

        $this->genLimiter->hit();
        $this->getSumLimiter->hit();

        return $dateTo;
    }

    protected function genVerificationCode(): string
    {
        return (string) mt_rand(1111, 9999);
    }

    static function keyGenerate(SmsNotifiable $smsNotifiable): string
    {
        return 'sms:verif:' . $smsNotifiable->getId() . $smsNotifiable->getPhoneAttribute();
    }
}

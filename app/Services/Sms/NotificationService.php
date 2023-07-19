<?php

namespace App\Services\Sms;

use App\Services\Cache\Throttles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Tzsk\Sms\Sms as BaseSms;

class NotificationService
{
    use Throttles;

    protected const DB = 'data';
    protected const KEY_EXP = 600;
    protected const GET_DECAY_SECONDS = 60;

    protected BaseSms $smsManager;

    public function __construct(
        protected SmsNotifiable $smsNotifiable,
    ) {
        $this->smsManager = new SmsManager();
        $this->key = $this->keyGenerate($this->smsNotifiable->getPhoneAttribute());
        $this->connection = Redis::connection();
    }

    /**
     * send sms
     *
     * @return Carbon - expiration time
     */
    public function sendCode(): Carbon
    {
        $verificationCode = $this->genVerificationCode();

        $clientPhone = $this->smsNotifiable->getPhoneAttribute()->getPhoneNumber();

        $this->throttle('sendCode', $this->key, fn () => $this->smsManager->to($clientPhone)
            ->send($verificationCode), __('validation.custom.too_many_attempts'), self::GET_DECAY_SECONDS);

        $this->connection->set($this->key, $verificationCode, 'EX', self::KEY_EXP);

        return Carbon::now()->addSeconds(self::GET_DECAY_SECONDS);
    }

    protected function genVerificationCode(): string
    {
        return (string) mt_rand(1111, 9999);
    }

    public static function keyGenerate(string $key): string
    {
        return 'sms:verify:' . $key;
    }
}

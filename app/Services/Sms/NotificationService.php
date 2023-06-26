<?php

namespace App\Services\Sms;

use App\Services\Cache\Throttles;
use Carbon\Carbon;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Tzsk\Sms\Sms as BaseSms;
use Illuminate\Support\Facades\Redis;

class NotificationService
{
    use Throttles;

    protected const DB                = 'data';
    protected const KEY_EXP           = 600;
    protected const GET_DECAY_SECONDS = 60;

    protected PhpRedisConnection $connection;
    protected BaseSms $smsManager;

    public function __construct(
        protected SmsNotifiable $smsNotifiable,
    ) {
        $this->smsManager       = new smsManager();
        $this->key              = $this->keyGenerate($this->smsNotifiable);
        $this->connection       = Redis::connection(self::DB);
    }

    /**
     * Отправялет смс
     * @return Carbon - expiration time
     */
    public function sentCode(): Carbon
    {
        $verificationCode = $this->genVerificationCode();

        $clientPhone = $this->smsNotifiable->getPhoneAttribute()->getPhoneNumber();

        $this->throttle('sendCode', $this->key, static fn () => $this->smsManager->to($clientPhone)
            ->send('code:' . $verificationCode), 'feedback.already_sms_sended', self::GET_DECAY_SECONDS);

        $this->connection->set($this->key, $verificationCode, 'EX', self::KEY_EXP);

        return Carbon::now()->addSeconds(self::KEY_EXP);
    }

    protected function genVerificationCode(): string
    {
        return (string) mt_rand(1111, 9999);
    }

    static function keyGenerate(SmsNotifiable $smsNotifiable): string
    {
        return 'sms:verify:' . $smsNotifiable->getId() . $smsNotifiable->getPhoneAttribute();
    }
}

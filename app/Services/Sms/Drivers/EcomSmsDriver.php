<?php

namespace App\Services\Sms\Drivers;

use App\Ecom\Ecom;
use App\Ecom\Connection;
use App\Enums\LoyaltyType;

class EcomSmsDriver extends BaseDriver
{
    protected Ecom $client;

    public function __construct()
    {
        $this->client = Connection::getConnection(loyaltyType());

        parent::__construct();
    }

    public function send()
    {
        $response = collect();
        foreach ($this->recipients as $recipient) {
            if ($this->isDebug) {
                $this->logger->info('SMS', $this->payload($recipient));
                continue;
            }
            $response->put($recipient, $this->client->post('/ecom/hs/sms/send/', $this->payload($recipient)));
        }

        return (count($this->recipients) == 1) ? $response->first() : $response;
    }

    public function payload($recipient)
    {
        return [
            'clientTel' => '+' . $recipient,
            'message'   => $this->body,
            'sendNow'   => true
        ];
    }
}

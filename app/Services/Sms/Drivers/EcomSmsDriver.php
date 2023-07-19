<?php

namespace App\Services\Sms\Drivers;

use App\Ecom\Connection;
use App\Ecom\Ecom;

class EcomSmsDriver extends BaseDriver
{
    protected Ecom $client;

    public function __construct()
    {
        $this->client = Connection::getConnection();

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

            $template = loyaltyType()->template();

            $response->put($recipient, $this->client->post("/ecom/hs/sms/templates/{$template}", $this->payload($recipient)));
        }

        return (count($this->recipients) === 1) ? $response->first() : $response;
    }

    public function payload($recipient)
    {
        return [
            'clientTel' => '+' . $recipient,
            'params' => [
                'code' => $this->body,
            ],
            'sendNow' => true,
            'serviceId' => loyaltyType()->projectLogin(),
        ];
    }
}

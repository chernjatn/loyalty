<?php

namespace Ultra\Shop\Services\Sms\Drivers;

use GuzzleHttp\Client;

class Intellin extends BaseDriver
{
    protected const URL = 'https://sms.intellin.ru/sendsms.cgi';
    protected Client $client;
    protected array $settings;

    public function __construct(array $settings)
    {
        $this->settings = [
            'http_username' => $settings['username'],
            'http_password' => $settings['password'],
            'fromphone'     => $settings['sender'],
        ];
        
        $this->client  = new Client();
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
            $response->put(
                $recipient,
                $this->client->get(self::URL, [
                    'query' => $this->payload($recipient)
                ])
            );
        }

        return (count($this->recipients) == 1) ? $response->first() : $response;
    }

    public function payload($recipient)
    {
        return $this->settings + [
            'phone_list' => $recipient,
            'message'    => $this->body,
        ];
    }
}

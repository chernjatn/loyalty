<?php

namespace Ultra\Shop\Services\Sms\Drivers;

use GuzzleHttp\Client;

class Devinotele extends BaseDriver
{
    protected const URL = 'https://integrationapi.net/';

    protected Client $client;
    protected string $username;
    protected string $password;

    public function __construct(array $settings)
    {
        $this->username = $settings['username'];
        $this->password = $settings['password'];
        $this->sender   = $settings['sender'];

        $this->client  = new Client([
            'base_uri' => self::URL
        ]);
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
                $this->client->post('/rest/v2/Sms/Send?' . urldecode(http_build_query($this->payload($recipient))))
            );
        }

        return (count($this->recipients) == 1) ? $response->first() : $response;
    }

    public function payload($recipient)
    {
        return [
            'DestinationAddress' => $recipient,
            'Data'               => $this->body,
            'SourceAddress'      => $this->sender,
            'Login'              => $this->username,
            'Password'           => $this->password
        ];
    }
}

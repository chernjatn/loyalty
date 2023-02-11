<?php

namespace App\Services\SMS;

class SmsService
{
    private Phone $phone;

    public function __construct(private Phone $phone)
    {
    }

    public function sendCode(): bool
    {
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        try {
            $easySms->send($mobile,
                ['content' => $code]);

        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $response = $exception->getResponse();
            $result = json_decode($response->getBody()->getContents(), true);
            $this->setMsg($result['msg'] ?? 'Отправка SMS ненормальная');
            return false;
        }
    }
}

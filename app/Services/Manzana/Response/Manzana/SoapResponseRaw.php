<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response;

class SoapResponseRaw
{
    private $response;
    private string $responseRaw;

    public function __construct($response, string $responseRaw)
    {
        $this->response = $response;
        $this->responseRaw = $responseRaw;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseRaw(): string
    {
        return $this->responseRaw;
    }
}

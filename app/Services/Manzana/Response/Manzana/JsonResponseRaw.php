<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response;

class JsonResponseRaw
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}

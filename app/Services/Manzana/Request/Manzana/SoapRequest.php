<?php

namespace Ultra\Shop\Services\Loyalty\Drivers\Manzana\Requests;

use SoapClient;
use Ultra\Shop\Services\Loyalty\Drivers\Manzana\Response\SoapResponseRaw;

abstract class SoapRequest
{
    protected string $orgName;
    protected string $organization;
    protected string $brand;
    protected SoapClient $soapClient;

    public function __construct()
    {
        $config = config('manzana.channels.' . rescue(fn () => channel()->getCode(), fn () => config('manzana.default')));

        $this->orgName      = $config['org_name'];
        $this->organization = $config['organization'];
        $this->brand        = $config['brand'];

        $this->soapClient = new SoapClient($config['soap']['wsdl'], $config['soap']['auth'] + ['features' => SOAP_SINGLE_ELEMENT_ARRAYS, 'trace' => true]);
    }

    protected function sendRequest(array $data = [], array  $options = []): SoapResponseRaw
    {
        return transform(
            $this->soapClient->ProcessRequest($data, $options),
            fn ($respObj) => new SoapResponseRaw($respObj, $this->soapClient->__getLastResponse())
        );
    }
}

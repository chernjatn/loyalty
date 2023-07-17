<?php

namespace App\Services\Loyalty\Drivers\Manzana\Requests;

use App\Enums\LoyaltyType;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class JSONRequest
{
    private const ADD_SLASHES = [
        'sessionId',
        'partnerId',
        'mobilePhone',
        'emailAddress',
        'contactId'
    ];

    protected string $customerDomain;
    protected string $managerDomain;
    protected string $partnerId;
    protected string $superSession;
    protected array $config;
    protected string $appId;

    public function __construct(LoyaltyType $loyaltyType)
    {
        $config = config('manzana.loyaltyType.' . mb_strtolower($loyaltyType->name), fn () => config('manzana.default'));

        $this->config         = $config;
        $this->appId          = $config['app_id'];
        $this->customerDomain = $config['json']['customer_domain'];
        $this->managerDomain  = $config['json']['manager_domain'];
        $this->partnerId      = $config['json']['partner_id'];
        $this->superSession   = $config['json']['super_session'];
    }

    protected function prepareSuperQuery(array $query): array
    {
        return $this->prepareQuery($query + [
            'sessionId' => $this->superSession,
        ]);
    }

    protected function prepareQuery(array $query): array
    {
        foreach (self::ADD_SLASHES as $addSlashesKey) {
            if (empty($query[$addSlashesKey])) continue;

            $query[$addSlashesKey] = "'" . addslashes($query[$addSlashesKey]) . "'";
        }

        return $query;
    }

    protected function preparePostSuperQuery($data)
    {
        return $this->preparePostQuery(['sessionId' => $this->superSession] + $data);
    }

    protected function preparePostQuery($data)
    {
        return ['parameter' => json_encode($data)];
    }

    protected function get(string $url, $query = null, ?string $key = null)
    {
        return $this->logResp(Http::acceptJson()->get($url, $query))->json($key);
    }

    protected function post(string $url, array $data = [], ?string $key = null)
    {
        return $this->logResp(Http::acceptJson()->post($url, $data))->json($key);
    }

    private function logResp(Response $resp): Response
    {
        $error = $resp->json('odata.error');
        if ($error) {
            Log::channel('loyalty')->error('manzana', $error);
        }

        return $resp;
    }

    abstract public function processRequest();
}

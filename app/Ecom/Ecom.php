<?php

namespace App\Ecom;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class Ecom
{
    private Client $client;

    public function __construct(string $baseUrl, string $user, string $password)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            RequestOptions::AUTH => [$user, $password],
            RequestOptions::HEADERS => [
                'cache-control' => 'no-cache',
                'connection' => 'keep-alive',
                'content-type' => 'application/json',
            ],
        ]);
    }

    public function get(string $page, array $params = [], int $timeout = 300): ?array
    {
        if (! empty($params)) {
            $page .= '?' . http_build_query($params);
        }

        $response = $this->client->get($page, [
            RequestOptions::TIMEOUT => $timeout,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function post(string $page, array $params = [], int $timeout = 300): ?array
    {
        self::prepareToken($page, $params);

        $response = $this->client->post($page, [
            RequestOptions::JSON => $params,
            RequestOptions::TIMEOUT => $timeout,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function put(string $page, array $params = [], int $timeout = 300): ?array
    {
        self::prepareToken($page, $params);

        $response = $this->client->put($page, [
            RequestOptions::JSON => $params,
            RequestOptions::TIMEOUT => $timeout,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function delete(string $page, array $params = [], int $timeout = 300): ?array
    {
        $response = $this->client->delete($page, [
            RequestOptions::JSON => $params,
            RequestOptions::TIMEOUT => $timeout,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getFile(string $path, $timeout = 60): ResponseInterface
    {
        return $this->client->get($path, [
            RequestOptions::TIMEOUT => $timeout,
        ]);
    }

    public function putFile(string $path, Media $file, $timeout = 60): ?array
    {
        $response = $this->client->put($path, [
            RequestOptions::TIMEOUT => $timeout,
            RequestOptions::HEADERS => [
                'name' => $file->file_name,
                'nameWithoutExtension' => $file->name,
                'extension' => '.' . $file->getExtensionAttribute(),
            ],
            RequestOptions::MULTIPART => [
                [
                    'Content-type' => 'multipart/form-data',
                    'name' => $file->name,
                    'filename' => $file->file_name,
                    'contents' => fopen($file->getPath(), 'r'),
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private static function prepareToken(string &$url, array &$params): void
    {
        if (isset($params['ecomtoken'])) {
            $url .= '?ecomtoken=' . $params['ecomtoken'];
            unset($params['ecomtoken']);
        }
    }
}

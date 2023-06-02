<?php
declare(strict_types=1);
namespace App\Symptom\Utils\Clients\HTTP;

use GuzzleHttp\Client as GuzzleClient;

class Client implements Http
{
    protected GuzzleClient $client;

    public function __construct()
    {
        $this->client = new GuzzleClient();
    }

    public function get(string $url, array $params = []): mixed
    {
        $response = $this->client->get($url, [
            'query' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function post(string $url, array $params = []): mixed
    {
        $response = $this->client->post($url, [
            'form_params' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}


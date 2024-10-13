<?php

namespace App;

use GuzzleHttp\Client;

class HttpClient
{
    private Client $client;

    public function __construct(string $baseUri)
    {
        $this->client = new Client(['base_uri' => $baseUri]);
    }

    public function fetchPage(string $endpoint, int $page): string
    {
        $response = $this->client->request('GET', "{$endpoint}?page={$page}");
       
        return $response->getBody()->getContents();
    }
}

<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService

{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getDataNws(): array
    {
        $response = $this->client->request(
            'GET',
            'http://vps-a47222b1.vps.ovh.net:4242/Student'
        );
        return $response->toArray();
    }
}
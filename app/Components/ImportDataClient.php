<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportDataClient
{
    public $client;

    /**
     * @param $client
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('API_URL_KONTUR'),
            'http_errors' => false,
            'headers' => [
                'x-Auth-CustomToken' => env('API_TOKEN_KONTUR'),
                'Accept' => 'application /json',
            ]
        ]);

    }

}

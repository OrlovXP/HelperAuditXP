<?php

namespace App\API;

use GuzzleHttp\Client;

class APIB24RequestService
{

    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('B24_URL').'/'.env('B24_WEBHOOK_USER_ID').'/'.env('B24_WEBHOOK').'/',
            //'http_errors' => false,
        ]);

    }



}

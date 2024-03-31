<?php

namespace App\API;

use App\API\APIB24RequestService;

use GuzzleHttp\Client;

class APIB24SetStatusDealsService
{


    // Надо установить стадию сделки из массива к Б24
    // Вернуть стадию


    public function status(): array
    {
        return [
            '1' => 'SALE',
            '2' => '1',
            '3' => '14',
        ];
    }

}


<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Bitrix24Api
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     */
    public function getList($nameFilter, $categoryId)
    {
        // Формируем параметры фильтрации
        $filter = [];
        if ($nameFilter) {
            $filter['TITLE'] = $nameFilter;
        }
        if ($categoryId) {
            $filter['CATEGORY_ID'] = $categoryId;
        }

        // Отправляем запрос с параметрами фильтрации
        return $this->sendRequest('crm.deal.list', ['filter' => $filter]);
    }

    /**
     * @throws GuzzleException
     */
    public function getDealId($inn)
    {
        $filter = ['=UF_CRM_1587639560' => $inn];
        // Отправляем запрос с параметрами фильтрации
        return $this->sendRequest('crm.deal.list', ['filter' => $filter]);
    }


    protected function sendRequest($method, $params = [])
    {
        $url = config('bitrix24.rest_endpoint') . "/{$method}.json";
        $accessToken = config('bitrix24.access_token');

        $response = $this->client->post($url, [
            'json' => array_merge($params, ['auth' => $accessToken]),
        ]);

        return json_decode($response->getBody(), true);
    }


}

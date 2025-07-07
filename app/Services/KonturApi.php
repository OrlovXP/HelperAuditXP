<?php

namespace App\Services;

use App\Models\NewsTimestamp;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KonturApi
{
    protected $apiToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiToken = config('kontur.apiToken');
        $this->apiUrl = config('kontur.apiUrl');
    }

    public function getTimestamp()
    {
        // Получаем токен API и URL из конфигурации Laravel
        $apiToken = config('kontur.apiToken');
        $apiUrl = config('kontur.apiUrl');

        // Создаем экземпляр Guzzle HTTP Client
        $client = new Client();

        try {
            // Отправляем GET-запрос к указанному URL
            $response = $client->request('GET', $apiUrl.'/prospectivesales/lasttimestamp', [
                'headers' => [
                    'x-Auth-CustomToken' => $apiToken,
                    'Accept' => 'application/json',
                ]
            ]);
            // Получаем содержимое ответа
            // Возвращаем метку времени в виде JSON-ответа
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Обработка ошибки, если запрос не удался
            return response()->json(['error' => 'Не удалось получить метку времени: '.$e->getMessage()], 500);
        }
    }


    public function getNews($timestamp)
    {
        // Создаем экземпляр Guzzle HTTP Client
        $client = new Client();

        // URL для запроса новостей
        $apiToken = config('kontur.apiToken');
        $apiUrl = config('kontur.apiUrl');
        $url = $apiUrl.'/prospectivesales/news/';

        try {
            // Отправляем GET-запрос к указанному URL
            $response = $client->request('GET', $url, [
                'headers' => [
                    'x-Auth-CustomToken' => $apiToken,
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'from' => 45470000000000 //45008012327762,
                ],
            ]);

            // Получаем содержимое ответа в виде JSON
            // Возвращаем список новостей в виде массива
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // Обработка ошибки, если запрос не удался
            return ['error' => 'Не удалось получить новости: '.$e->getMessage()];
        }
    }

    public function printDeal($id = null)
    {
        if ($id === null || trim($id) === '') {
            return null;  // return null or throw an exception, depending on your requirements
        }

        $apiToken = config('kontur.apiToken');
        $apiUrl = config('kontur.apiUrl');
        $url = "{$apiUrl}/prospectivesales/{$id}/find";

        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'x-Auth-CustomToken' => $apiToken,
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function saveTimestamp($timestamp)
    {
        NewsTimestamp::create(['timestamp' => $timestamp]);
    }
}

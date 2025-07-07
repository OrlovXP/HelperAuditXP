<?php

namespace App\Services;

use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FocusApi
{
    private $client;
    private $apiKey = 'ee1c0123dca3214945bbff8b486b2acb9d53ce60';
    private $apiEndPoint = 'https://focus-api.kontur.ru/api3/';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function req($inn)
    {
        $response = $this->getRequest($inn);
        //dd($response); // UL может не быть
        //dd($response[0]['UL']); // UL может не быть
        if (!empty($response) && isset($response[0]['UL'])) {
            $data = $response[0]['UL'];
            $inn = $response[0]['inn'];
            $ogrn = $response[0]['ogrn'];

            $address = $data['legalAddress']['parsedAddressRF'];


//            "houseRaw" => "К. 307"
//  "flatRaw" => "КВ. 52"
            $addressRF = [
                'regionCode' => $address['regionCode'],
                'zipCode' => $address['zipCode'],
                'regionName' => $address['regionName']['topoFullName'].' '.$address['regionName']['topoValue'],
            ];
            // buildings
            if(isset($address['city'])) {
                $addressRF['city'] = $address['city']['topoFullName'].' '.$address['city']['topoValue'];
            }

            if(isset($address['street'])) {
                $addressRF['street'] = $address['street']['topoFullName'].' '.$address['street']['topoValue'];
            }

            if(isset($address['houseRaw'])) {
                $addressRF['house'] = $address['houseRaw'] . ", ";
            }

            if(isset($address['flatRaw'])) {
                $addressRF['flat'] = $address['flatRaw'];
            }

            //dump($address, $addressRF);

            $result = [
                'focus_region_code' => $address['regionCode'],
                'focus_address' => $address['zipCode'].', '
                    .$address['regionName']['topoFullName'].' '
                    .$address['regionName']['topoValue'].', '

                    .(isset($address['city']) ? $address['city']['topoFullName'].' '.$address['city']['topoValue'] : '').', '
                    .(isset($address['street']) ? $address['street']['topoFullName'].' '.$address['street']['topoValue'].', ' : '')
                    .($addressRF['house'] ?? '')
                    .($addressRF['flat'] ?? ''),


                //.$addressRF['house'],
                //$addressRF['house'],
                //$addressRF['flat'],


                'focus_dissolution_date' => $data['dissolutionDate'] ?? null,
                'focus_registration_date' => $data['registrationDate'] ?? null,
                'focus_head' => $data['heads'][0]['fio'],
                'focus_status' => $data['status']['statusString'],
                'focus_inn' => $inn,
                'focus_ogrn' => $ogrn,
                'focus_subject' => $address['regionName']['topoShortName'].' '.$address['regionName']['topoValue'], // fddffddf
                'focus_is_synchronized' => true
            ];

            DB::table('registries')->where('basic_inn', $inn)->update($result);

            //dd($result);
            return $result;
        }
    }


    private function getRequest($inn)
    {
        try {
            $response = $this->client->request('GET', $this->apiEndPoint.'req?key='.$this->apiKey.'&inn='.$inn, [
                'headers' => [
                    'Authorization' => 'Token '.$this->apiKey,
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                return json_decode($body, true);
            } else {
                // обработка ошибки
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Обработка ошибок, связанных с запросом
        } catch (\Exception $e) {
            // Обработка других ошибок
        }

        return null;
    }

    public function getStat(): array
    {
        $response = $this->client->request('GET', $this->apiEndPoint.'stat', [
            'query' => [
                'key' => $this->apiKey
            ]
        ]);

        $content = json_decode($response->getBody()->getContents(), true);

        return [
            'limit' => $content[7]['limit'],
            'spent' => $content[7]['spent']
        ];
    }
}

<?php

namespace App\Services;

use App\Models\Bitrix24CompanyType;
use App\Models\Registry;
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

    public function getCompanyId($inn)
    {
        $filter = ['=UF_CRM_1675089975' => $inn];
        // Отправляем запрос с параметрами фильтрации
        return $this->sendRequest('crm.company.list', ['filter' => $filter]);
    }



    public function updateCompanyB24($companyId, $fields)
    {
        // Отправляем запрос на обновление компании
        return $this->sendRequest('crm.company.update', ['id' => $companyId, 'fields' => $fields]);
    }


    public function updateDeal($params)
    {
        // Отправляем запрос на обновление сделки
        return $this->sendRequest('crm.deal.update', $params);
    }

    public function getCompanyList(?string $inn = null): string|null
    {
        $filter = [];
        if ($inn) {
            $filter['UF_CRM_1441615404'] = $inn; // Предположим, что ИНН хранится в пользовательском поле с кодом UF_CRM_1441615404
        }

        $response = $this->sendRequest('crm.company.list', ['filter' => $filter]);

        if (!empty($response['result']) && isset($response['result'][0]['ID'])) {
            return $response['result'][0]['ID'];
        }

        return null;
    }

    // Perser

    public function getCompanyRequisites(string $inn)
    {
        $filter = [
            '=UF_CRM_1441615404' => $inn,
        ];
        $select = [
            'ID', 'COMPANY_TYPE',
        ];

        // get the company first
        $response = $this->sendRequest('crm.company.list', ['filter' => $filter, 'select' => $select]);

        $companies = $response['result'] ?? [];

        if (count($companies) > 0) {
            // Assume we take the first company found
            $company = $companies[0];

            // Prepare a filter to get the requisites of the company
            $requisitesFilter = [
                'ENTITY_ID' => $company['ID'],
                'ENTITY_TYPE_ID' => 4, // as per Bitrix24 documentation, 4 - is a company
            ];

            // Get the requisites of the company
            $response = $this->sendRequest('crm.requisite.list', ['filter' => $requisitesFilter]);

            return $response['result'] ?? [];
        }

        return [];
    }


    public function getCompany(string $inn)
    {
        $filter = [
            '=UF_CRM_1441615404' => $inn,
        ];
        $select = [
            'ID', 'COMPANY_TYPE',
        ];


        $response = $this->sendRequest('crm.company.list', ['filter' => $filter, 'select' => $select]);

        return $response['result'] ?? [];
    }

    public function getAllCompanyClientsTest()
    {
        $response = $this->sendRequest('crm.company.list', [
            'filter' => [
                '=UF_CRM_1449494297' => '1067',
                '!=UF_CRM_1675089975' => false
            ],
            'select' => ['ID', 'TITLE', 'REQUISITES'],
        ]);

        foreach ($response['result'] as $company) {
            $requisitesResponse = $this->sendRequest('crm.requisite.list', [
                'filter' => ['ENTITY_ID' => $company['ID']]
            ]);


                $company['REQUISITES'] = $requisitesResponse['result'];
                $allClients[] = $company;

        }
        return $allClients;
    }


    public function getAllCompanyClients(int $start, int $end): array
    {
        $allClients = [];
        $itemsPerPage = 50;


        for ($offset = $start; $offset <= $end; $offset += $itemsPerPage) {
            $response = $this->sendRequest('crm.company.list', [
                'start' => $offset,
                'filter' => [
                    '=UF_CRM_1449494297' => '1067',
                    '!=UF_CRM_1675089975' => false
                ],
                'select' => ['ID', 'TITLE', 'UF_CRM_1675089975','COMPANY_TYPE', 'REQUISITES'],
            ]);

            $companyIds = array_column($response['result'], 'ID');

            $requisitesResponse = $this->sendRequest('crm.requisite.list', [
                'filter' => ['ENTITY_ID' => $companyIds]
            ]);

            $idNameMap = [];
            $ogrnMap = [];
            foreach ($requisitesResponse['result'] as $requisite) {

                if (!empty($requisite['RQ_COMPANY_NAME'])) {
                    $name = $requisite['RQ_COMPANY_NAME'];
                } else {
                    $firstName = $requisite['RQ_FIRST_NAME'] ?? '';
                    $lastName = $requisite['RQ_LAST_NAME'] ?? '';
                    $secondName = $requisite['RQ_SECOND_NAME'] ?? '';

                    $name = trim("{$lastName} {$firstName} {$secondName}");
                }
                $idNameMap[$requisite['ENTITY_ID']] = $name;
                $ogrnMap[$requisite['ENTITY_ID']] = $requisite['RQ_OGRN'] ?? null;

            }

            foreach ($response['result'] as $company) {

                if (array_key_exists($company['ID'], $idNameMap)) {
                    $company['NAME'] = $idNameMap[$company['ID']];
                    $company['RQ_OGRN'] = $ogrnMap[$company['ID']];

                    // Enter your code snippet here
                    if (isset($company['COMPANY_TYPE'])) {
                        $statusName = $this->getCompanyNameByStatusId($company['COMPANY_TYPE']);
                        if ($statusName) {
                            $bitrix24Type = Bitrix24CompanyType::firstOrCreate(['type' => $statusName]);
                            $company['BITRIX24_COMPANY_TYPE_ID'] = $bitrix24Type->id;
                        }
                    }

                    Registry::updateOrCreate(
                        ['basic_inn' => $company['UF_CRM_1675089975']],
                        [
                            'name' => $company['NAME'],
                            'basic_inn' => $company['UF_CRM_1675089975'],
                            'ogrn' => $company['RQ_OGRN'],
                            'bitrix24_company_type_id' => $company['BITRIX24_COMPANY_TYPE_ID'],
                            'company_b24' => true,
                            'aac_is_not_registry' => true,
                        ]
                    );


                    $allClients[] = $company;
                }
            }
        }

        return $allClients;
    }


//    public function getAllCompanyClients(): array
//    {
//        $nextPage = 0;
//        $allClients = [];
//
//        do {
//            $response = $this->sendRequest('crm.company.list', [
//                'start' => $nextPage,
//                'filter' => [
//                    '=UF_CRM_1449494297' => '1067',
//                    '!=UF_CRM_1675089975' => false
//                ],
//                'select' => ['ID', 'TITLE', 'REQUISITES'],
//            ]);
//
//            // Получаем реквизиты для каждой компании и добавляем их в информацию о компании
//            foreach ($response['result'] as $company) {
//                $requisitesResponse = $this->sendRequest('crm.requisite.list', [
//                    'filter' => ['ENTITY_ID' => $company['ID']]
//                ]);
//
//                // Check if REQUISITES contains more than one array. If so, add it to the $allClients array
//                if (count($requisitesResponse['result']) > 1) {
//                    $company['REQUISITES'] = $requisitesResponse['result'];
//                    $allClients[] = $company;
//                }
//            }
//            $nextPage = $response['next'] ?? null;
//        } while ($nextPage !== null);
//
//
//        return $allClients; // Возвращаем массив со всеми клиентами
//    }


    public function getCompanyNameByStatusId($id)
    {
        $statuses = $this->sendRequest('crm.status.list',
            ['order' => ["SORT" => "ASC"], 'filter' => ["ENTITY_ID" => "COMPANY_TYPE"]]);

        foreach ($statuses['result'] as $status) {
            if ($status['STATUS_ID'] === $id) {
                return $status['NAME'];
            }
        }

        return null;
    }


    public function getDealsWithFilter($filter, $select = [], $order = [])
    {
        $response = $this->sendRequest('crm.deal.list', ['filter' => $filter, 'select' => $select, 'order' => $order]);
        return $response['result'] ?? null;
    }


    public function getUserfield()
    {
        return $this->sendRequest('crm.deal.userfield.list');
    }

    public function getStatus()
    {
        return $this->sendRequest('crm.invoice.status.list');
    }

    public function getValue($idField, $idProduct)
    {
        $response = $this->sendRequest('crm.deal.userfield.get', ['id' => $idField]);

        // Проверяем, что полученный ответ содержит 'LIST'
        if (isset($response['result']['LIST'])) {
            foreach ($response['result']['LIST'] as $item) {
                if ($item['ID'] == $idProduct) {
                    return $item['VALUE'];
                }
            }
        }

        // Возвращаем пустую строку или null, если в ответе нет 'LIST' или если не удалось найти совпадение
        return "";
    }

    public function addCompany($fields)
    {
        return $this->sendRequest('crm.company.add', [
            'fields' => $fields,
            'params' => ['REGISTER_SONET_EVENT' => 'Y']
        ]);
    }

    public function getCompanyfields()
    {
        return $this->sendRequest('crm.company.fields');
    }

    /**
     * @throws GuzzleException
     */
    protected function sendRequest($method, $params = [])
    {
        $url = config('bitrix24.rest_endpoint')."/{$method}.json";
        $accessToken = config('bitrix24.access_token');

        $response = $this->client->post($url, [
            'json' => array_merge($params, ['auth' => $accessToken]),
        ]);

        usleep(1500000);

        return json_decode($response->getBody(), true);
    }


}

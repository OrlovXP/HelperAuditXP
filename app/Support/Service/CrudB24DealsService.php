<?php

namespace App\Support\Service;


use App\API\APIB24RequestService;
use GuzzleHttp\Exception\GuzzleException;

class CrudB24DealsService
{
    public function stageCheck($id): ?bool
    {
        $array = ['C13:13', 'C13:17', 'C13:18', 'C13:FINAL_INVOICE', 'C13:12', 'C13:WON'];

        $request = new APIB24RequestService();
        $response = $request->client->request('POST', 'crm.deal.list.json', [
            'form_params' => [
                'filter' => [
                    '=UF_CRM_1587639560' => $id,
                ],
                'select' => ['STAGE_ID']
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());


        if (empty($response->result)) {
            return null;
        }
        return in_array($response->result[0]->STAGE_ID, $array);
    }

    public function search($id)
    {
        $request = new APIB24RequestService();
        $response = $request->client->request('POST', 'crm.deal.list.json', [
            'form_params' => [
                'filter' => [
                    '=UF_CRM_1587639560' => $id,
                ],
                'select' => ['id']
            ]
        ]);
        $response = json_decode($response->getBody()->getContents());

        if ($response->total == 0) {
            return null;
        }
        return $response->result[0]->ID;
    }


    /**
     * @throws GuzzleException
     */
    public function update($id, array $array): void
    {
        if (empty($array['bills']) || !empty($array['stages_id'])) {
            foreach ($array['stages_id'] as $value) {
                $res = in_array($value->StageId,
                    ['47583553-8582-49d5-8337-d66a75001530', '9d3d7591-d41d-4c5e-9897-316383892dfc']);

                if ($res) {
                    $request = new APIB24RequestService();
                    $request->client->request('POST', 'crm.deal.update.json', [
                        'form_params' => [
                            'ID' => $id,
                            'fields' => [
                                'STAGE_ID' => 'C13:PREPARATION',
                            ]
                        ]
                    ]);
                    break;
                }
            }
        } else {
            $request = new APIB24RequestService();
            $request->client->request('POST', 'crm.deal.update.json', [
                'form_params' => [
                    'ID' => $id,
                    'fields' => [
                        'STAGE_ID' => 'C13:EXECUTING',
                    ]
                ]
            ]);
        }

        $request = new APIB24RequestService();
        $request->client->request('POST', 'crm.deal.update.json', [
            'form_params' => [
                'ID' => $id,
                'fields' => [
                    'STAGE_ID' => setFailStatus($array['fail']),
                    'ASSIGNED_BY_ID' => $array['assigned'],
                ]
            ]
        ]);


        if (!empty($array['bills'])) {
            $number = $this->getNumber($array['bills']);

            if (!empty($number)) {

                $request = new APIB24RequestService();
                $request->client->request('POST', 'crm.deal.update.json', [
                    'form_params' => [
                        'ID' => $id,
                        'fields' => [
                            'TITLE' => implode(' / ', $number['number']),
                            'OPPORTUNITY' => array_sum($number['amount']),
                            'UF_CRM_1524952869' => $number['date'][0],
                            'STAGE_ID' => $number['state'],
                        ]
                    ]
                ]);
            }
        }
    }


    /**
     * @throws GuzzleException
     */
    public function add(int $category_id, array $array): void
    {
        $request = new APIB24RequestService();
        $request->client->request('POST', 'crm.deal.add.json', [
            'form_params' => [
                'fields' => [
                    "CATEGORY_ID" => $category_id,
                    'TITLE' => $array['title'],
                    'UF_CRM_1587639560' => $array['id_new'],
                    'UF_CRM_1666877042' => "https://billy-partners.kontur.ru/prospectivesale/{$array['id_new']}",
                    'UF_CRM_1486372471' => [4673], //284
                    'UF_CRM_5D3AD251D7FBA' => $array['inn'],
                    'UF_CRM_1697705848' => $array['inn'], // Новое поле ИНН2
                    'UF_CRM_5D3AD252176EB' => $array['kpp'],
                    'UF_CRM_1449516944' => setProduct($array['product']),
                    'TYPE_ID' => setValue($array['status'], ['1' => 'SALE', '2' => '1', '3' => '2']),
                    'COMPANY_ID' => getIdCompany($array['inn']),
                    'ASSIGNED_BY_ID' => $array['assigned'],
                    'bills' => $array['bills'],
                    'STAGE_ID' => setFailStatus($array['fail']),
                    'CLOSEDATE' => $array['estimated_closing_date'],
                ],
            ]
        ]);

        if (!empty($array['bills'])) {
            $number = $this->getNumber($array['bills']);

            if (!empty($number)) {
                $deal = new CrudB24DealsService();
                $id = $deal->search($array['id_new']);

                $request = new APIB24RequestService();
                $request->client->request('POST', 'crm.deal.update.json', [
                    'form_params' => [
                        'ID' => $id,
                        'fields' => [
                            'TITLE' => implode(' / ', $number['number']),
                            'OPPORTUNITY' => array_sum($number['amount']),
                            'UF_CRM_1524952869' => $number['date'][0],
                            'STAGE_ID' => $number['state'],
                        ]
                    ]
                ]);
            }
        }
    }

    /**
     * @param $bills
     * @return array
     */
    public function getNumber($bills): array
    {
        $number = [];
        foreach ($bills as $bill) {
            if ($bill->State == 1) {
                $number['number'][] = $bill->Number;
                $number['amount'][] = $bill->Amount;
                $number['state'] = 'C13:17';
                if (!is_null($bill->PaymentDate)) {
                    $number['date'][] = $bill->PaymentDate;
                } else {
                    $number['date'][] = '';
                }
            } elseif ($bill->State == 2) {
                $number['number'][] = $bill->Number;
                $number['amount'][] = $bill->Amount;
                $number['state'] = 'C13:13';
                $number['date'][] = '';
            }
        }
        return $number;
    }

    /**
     * @throws GuzzleException
     */
    public function searchCompany($inn)
    {
        $request = new APIB24RequestService();
        $response = $request->client->request('POST', 'crm.company.list.json', [
            'form_params' => [
                'filter' => [
                    '=UF_CRM_1441615404' => $inn,
                ],
                'select' => ['id', 'TITLE', 'UF_CRM_1441615404']
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());

        if ($response->total == 0) {
            return null;
        }
        return $response->result[0]->ID;
    }

    public function addCompany(array $array): void
    {
        //dump($array);
        $emails = [];
        $phones = [];
        foreach ($array['contacts'] as $contacts) {
            if (!empty($contacts->Emails)) {
                foreach ($contacts->Emails as $email) {
                    list($username, $domain) = explode('@', $email->Address);

                    if (checkdnsrr($domain, 'MX')) {
                        $emails[] = [
                            "VALUE" => $email->Address,
                            "VALUE_TYPE" => 'WORK',
                        ];
                    }
                }
            }
            if (!empty($contacts->Phones)) {
                foreach ($contacts->Phones as $phone) {
                    $phones[] = [
                        "VALUE" => $phone->Number,
                        "VALUE_TYPE" => 'WORK',
                    ];
                }
            }
        }

        $request = new APIB24RequestService();
        $request->client->request('POST', 'crm.company.add.json', [
            'form_params' => [
                'fields' => [
                    'TITLE' => $array['inn'].' '.$array['name'],
                    'UF_CRM_1441615404' => $array['inn'],
                    'UF_CRM_1675089975' => $array['inn'], // Новое поле ИНН2
                    'UF_CRM_1449494297' => $array['product'],
                    'PHONE' => $phones,
                    'EMAIL' => $emails,
                    'COMPANY_TYPE' => 'PROSPECT',
                    'ASSIGNED_BY_ID' => $array['assigned'],
                ],
            ]

        ]);
    }
}


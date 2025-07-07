<?php

namespace App\Support\Service;


use App\API\APIB24RequestService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;

class CrudB24BillsService
{

    /**
     * @throws GuzzleException
     */
    public function search($id)
    {
        $request = new APIB24RequestService();
        $response = $request->client->request('POST', 'crm.item.list.json', [
            'form_params' => [
                'entityTypeId' => 31,
                'filter' => ['=ufCrmSmartInvoice1675174858852' => $id],
                'select' => ['id'],
            ]
        ]);

        $response = json_decode($response->getBody()->getContents());

        if ($response->total == 0) {
            return null;
        }
        return $response->result->items[0]->id;
    }

    /**
     * @throws GuzzleException
     */
    public function update($id, $bill): void
    {
        $request = new APIB24RequestService();
        $request->client->request('POST', 'crm.item.update.json', [
            'form_params' => [
                'entityTypeId' => 31,
                'id' => $id,
                'fields' => [
                    'stageId' => setValue($bill['stage'], ['0' => 'DT31_1:N', '1' => 'DT31_1:2', '2' => 'DT31_1:1', '3' => 'DT31_1:2']),
                    'assignedById' => $bill['assigned'],
                    'companyId' => getIdCompany($bill['company']),
                    'begindate' => ($bill['create_date'] !== null) ? $bill['create_date'] : '',
                    'ufCrm_SMART_INVOICE_1679483415' => ($bill['payment_date'] !== null) ? $bill['payment_date'] : '',
                ]
            ]
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function add($id, $bill): void
    {
        $request = new APIB24RequestService();
        $request->client->request('POST', 'crm.item.add.json', [
            'form_params' => [
                'entityTypeId' => 31,
                'fields' => [
                    'title' => $bill['title'],
                    'opportunity' => $bill['amount'],
                    'parentId2' => $id, // $id
                    'ufCrm_SMART_INVOICE_1676278031' => $bill['id_deal'],
                    'ufCrm_SMART_INVOICE_1675174858852' => $bill['id_bill'],
                    'stageId' => setValue($bill['stage'], ['0' => 'DT31_1:N', '1' => 'DT31_1:2', '2' => 'DT31_1:1']),
                    'assignedById' => $bill['assigned'],
                    'companyId' => getIdCompany($bill['company']),
                    'begindate' => ($bill['create_date'] !== null) ? $bill['create_date'] : '',
                    'ufCrm_SMART_INVOICE_1679483415' => ($bill['payment_date'] !== null) ? $bill['payment_date'] : '',
                    'ufCrmSmartInvoice1679551972' => "https://billy-partners.kontur.ru/billinfo/{$bill['link']}",
                ]
            ]
        ]);
    }
}

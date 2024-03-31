<?php

namespace App\API;

use App\API\APIB24RequestService;

use GuzzleHttp\Client;

class APIB24AddDealsService
{


    public $client;

    public function add(){


    $connect = new APIB24RequestService('crm.deal.add', [
        'fields' => array(
            "CATEGORY_ID" => 17,
            'TITLE' => "ПП - test",
            //'TITLE' => "ПП".' '.$array["Organization"]["Inn"].' '.$array["Product"]["Name"],
            //'COMPANY_ID' => findCompanyInB24($array["Organization"]["Inn"]), // ИНН компании
            //'BEGINDATE' => $array['CreateTime'],
            //'CLOSEDATE' => $array['LifeTime'],
            //'UF_CRM_1587639560' => $array['Id'],
            'UF_CRM_1486372471' => [284],
            //'UF_CRM_1449516944' => setProduct($array['Product']['Name']),
            //'UF_CRM_1666877042' => "https://billy-partners.kontur.ru/prospectivesale/{$array['Id']}",
            //'TYPE_ID' => setStatus($array['Type']),
            'ASSIGNED_BY_ID' => 141, // 8

        ),
    ]);


    dump($connect);


}


}


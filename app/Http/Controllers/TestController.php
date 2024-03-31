<?php

namespace App\Http\Controllers;

use App\Components\ImportDataClient;
use App\Models\NewsTimestamp;
use App\Services\Bitrix24Api;
use App\Services\KonturApi;
use App\Support\Service\CrudB24BillsService;
use App\Support\Service\CrudB24DealsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{

    /**
     * @throws GuzzleException
     */
    public function __invoke()
    {
        $timestamp = DB::table('news_timestamps')->value('timestamp');
        if (is_null($timestamp)) {
            $news = new ImportDataClient();
            $news = $news->client->request('GET', '/prospectivesales/lasttimestamp',
                [
                    'query' => [
                        'from' => $timestamp,
                    ]
                ]
            );
            $timestamp = json_decode($news->getBody()->getContents());

            NewsTimestamp::create([
                'timestamp' => $timestamp,
            ]);
        }

//        start
        $news = new ImportDataClient();
        $news = $news->client->request('GET', '/prospectivesales/news',
            [
                'query' => [
                    'from' => $timestamp, // 31328248831827
                ]
            ]
        );


        $news = json_decode($news->getBody()->getContents());

        if (!empty($news->News)) {
            foreach ($news->News as $new) {
                $deal = new CrudB24DealsService();
                $id = $deal->search($new->Id);

                if ($deal->searchCompany($new->Organization->Inn) === null) {
                    $company = [
                        'name' => $new->Organization->Name,
                        'inn' => $new->Organization->Inn,
                        'product' => $new->Product->Name,
                        'contacts' => $new->Contacts,
                        'assigned' => setManager($new->Manager, $new->SalesChannel),
                    ];
                    $deal->addCompany($company);
                }

                if (is_null($id) and $deal->stageCheck($new->Id) === null) {
                    $deal->add('13', [
                        'title' => 'ПП '.$new->Organization->Inn.'-'.$new->Product->Name,
                        'id_new' => $new->Id,
                        'inn' => $new->Organization->Inn,
                        'kpp' => $new->Organization->Kpp,
                        'product' => $new->Product->Name,
                        'status' => $new->Type,
                        'assigned' => setManager($new->Manager, $new->SalesChannel),
                        'bills' => $new->Bills,
                        'fail' => $new->Status->ClientRefuseReasonId,
                        'estimated_closing_date' => $new->LifeTime,
                    ]);

                    $id = $deal->search($new->Id);
                    foreach ($new->Bills as $item) {
                        $bill = new CrudB24BillsService();
                        $bill->add($id, [
                            'title' => $item->Number,
                            'id_bill' => $item->BillId,
                            'amount' => $item->Amount,
                            'id_deal' => $new->Id,
                            'stage' => $item->State,
                            'assigned' => setManager($new->Manager, $new->SalesChannel),
                            'company' => $new->Organization->Inn,
                            'payment_date' => $item->PaymentDate,
                            'create_date' => $item->CreateDate,
                            'link' => $item->BillId,
                        ]);
                    }
                } else {
                    if ($deal->stageCheck($new->Id) !== true) {
                        $deal->update($deal->search($new->Id), [
                            'title' => 'ПП '.$new->Organization->Inn.'-'.$new->Product->Name,
                            'assigned' => setManager($new->Manager, $new->SalesChannel),
                            'bills' => $new->Bills,
                            'fail' => $new->Status->ClientRefuseReasonId,
                            'stages_id' => $new->Stages,
                        ]);

                        foreach ($new->Bills as $item) {
                            $bill = new CrudB24BillsService();
                            $bill_id = $bill->search($item->BillId);
                            $deal_id = $deal->search($new->Id);

                            if (is_null($bill_id)) {
                                $bill->add($deal_id, [
                                    'title' => $item->Number,
                                    'id_bill' => $item->BillId,
                                    'amount' => $item->Amount,
                                    'id_deal' => $new->Id,
                                    'stage' => $item->State,
                                    'assigned' => setManager($new->Manager, $new->SalesChannel),
                                    'company' => $new->Organization->Inn,
                                    'payment_date' => $item->PaymentDate,
                                    'create_date' => $item->CreateDate,
                                    'link' => $item->BillId,
                                ]);
                            } else {
                                $bill->update($bill_id, [
                                    'title' => $item->Number,
                                    'stage' => $item->State,
                                    'assigned' => setManager($new->Manager, $new->SalesChannel),
                                    'company' => $new->Organization->Inn,
                                    'payment_date' => $item->PaymentDate,
                                    'create_date' => $item->CreateDate,
                                ]);
                            }
                        }
                    }
                }
            }
        }
//        stop


        DB::table('news_timestamps')->delete();

        NewsTimestamp::create([
            'timestamp' => $news->NextTimestamp,
        ]);
    }
}

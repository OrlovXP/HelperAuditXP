<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\Bitrix24Api;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class TestBitrixController extends Controller
{
    protected $bitrixApi;

    public function __construct(Bitrix24Api $bitrixApi)
    {
        $this->bitrixApi = $bitrixApi;
    }

    /**
     * @throws GuzzleException
     */
    public function testMethod()
    {


        try {
            // Найти сделку по TITLE
            $dealTitle = '2493967390K1'; // Замените на нужное название сделки
            $categoryId = 11; // Подставьте нужную категорию
            $response = $this->bitrixApi->getList($dealTitle, $categoryId);

            dd($response);

        } catch (GuzzleException $e) {
            // Обработка ошибки запроса к API Bitrix24
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Обработка других исключений
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}


//$queryUrl = 'https://sckontur.bitrix24.ru/rest/141/pdwgkucetdezzjk2/crm.deal.update.json';
//$queryData = array(
//    "ID" => $item['ID_DEAL'],
//    "FIELDS" => array(
//        "STAGE_ID" => 'C11:WON',
//        "UF_CRM_1450794143" => $item['REWARD'],
//        "UF_CRM_1534334407" => $item['AGENT_REPORT_FOR'],
//    )
//);

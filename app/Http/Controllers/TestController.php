<?php

namespace App\Http\Controllers;

use App\Components\ImportDataClient;
use App\Jobs\CreateItemRegistry;
use App\Jobs\GetCompanyClientsB24Job;
use App\Jobs\ParseListRegistryJob;
use App\Jobs\UpdateCompanyB24Job;
use App\Models\Auditor;
use App\Models\Bitrix24CompanyType;
use App\Models\Inspection;
use App\Models\Phone;
use App\Models\Registry;
use App\Models\Status;
use App\Services\Bitrix24Api;
use App\Services\FocusApi;
use Goutte\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * @throws GuzzleException
     */
    public function __invoke(Bitrix24Api $bitrix24Api)
    {

        $bitrix24Api->getAllCompanyClients(0,1);

//        $registries = Registry::all();
//
//        foreach ($registries as $registry) {
//            $companyLink = 'http://helper.auditxp.ru/audit-organizations/' . $registry->basic_inn;
//            $fields = [
//                'UF_CRM_1600944854' => $registry->employees_count, // количество аудиторов
//                'UF_CRM_1720185071' => $companyLink,
//            ];
//
//            UpdateCompanyB24Job::dispatch($registry->basic_inn, $fields);
//
//        }


// {$this->ornz}

//        dump($bitrix24Api->getAllCompanyClients()); // 4093
//        $registry = Registry::where('basic_inn', '7735060400')->first();
//        dd($registry->employees_count);
        //dump($bitrix24Api->updateCompanyB24(6774, ['UF_CRM_1720185071' => '7735060400', 'UF_CRM_1600944854' => 5]));
        // 7735060400


//        DB::table('phones')->delete();
//        DB::table('registries')->delete();
//        DB::table('inspections')->delete();
//        DB::table('auditors')->delete();
//        DB::table('bitrix24_company_type')->delete();
//        DB::table('jobs')->delete();
//        DB::table('failed_jobs')->delete();
//        DB::table('plans')->delete();
//        dd();


    }
}

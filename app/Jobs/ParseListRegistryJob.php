<?php

namespace App\Jobs;

use App\Models\Phone;
use App\Models\Registry;
use DB;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ParseListRegistryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $client = new Client();
        $listOrganizations = $client->request('GET', 'https://sroaas.ru/reestr/organizatsiy/');

        $pageCount = null;
        $listOrganizations->filter('.b-pagination-block a')->eq(4)->each(function ($node) use (&$pageCount) {
            $pageCount = $node->text();  // этот код должен выводить "44"
        });


        for ($i = 1; $i <= $pageCount; $i++) {
            $ornzOrganizations = $client->request('GET',
                'https://sroaas.ru/reestr/organizatsiy/?PAGEN_1='.$i.'#nav_start');

            $ornzOrganizations->filter('.table-responsive tbody tr')->each(function ($node) use (&$ornz) {
                $tds = $node->filter('td');
                $ornz = $tds->eq(1)->text();

                //$registryExists = Registry::where('ornz', $ornz)->exists();

                // Если реестр с таким ИНН не существует, то создаем его.
                // Если реестр существует, то обновляем его.
                // Все процессы добавляются в очередь.

                //if (!$registryExists) {
                    dispatch(new CreateItemRegistry($ornz));
                //}

//                if ($registryExists) {
//                    dispatch(new UpdateItemRegistry($ornz))->delay(now()->addSecond());
//                }


            });

              //break;


        }
    }
}

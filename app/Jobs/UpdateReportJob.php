<?php

namespace App\Jobs;

use App\Models\Report;
use App\Services\Bitrix24Api;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Report $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function handle(Bitrix24Api $bitrixApi): void
    {
        $dealTitle = $this->report->check; // Замените на нужное название сделки
        $categoryId = 11; // Подставьте нужную категорию

        try {
            $response = $bitrixApi->getList($dealTitle, $categoryId);

            if (!empty($response['result'])) {
                $deal = $response['result'][0];

                $this->report->crm_deal_id = $deal['ID'];
                $this->report->crm_company_id = $deal['COMPANY_ID'];

                // Проверка суммы
                $expectedSum = $this->report->sum;
                $dealSum = $deal['OPPORTUNITY'];

                if ($dealSum != $expectedSum) {
                    $this->report->status = 'Amounts are not equal';
                    // Другие действия при несовпадении сумм
                } else {
                    $this->report->status = 'Ready for exchange';
                    // Другие действия при успешной обработке
                }

            } else {
                // Если сделка не найдена, установить значение "сделка не найдена" в столбец "status"
                $this->report->status = 'Not found';
            }

            $this->report->save();
        } catch (\Exception $e) {
            // Обработка других ошибок
        } catch (GuzzleException $e) {
            // Обработка ошибок Guzzle
        }
    }
}

<?php

namespace App\Jobs;

use App\Services\Bitrix24Api;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateDealJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $crm_deal_id;
    private mixed $check;
    private float $reward;

    private  mixed $report_date_for;

    public function __construct($crm_deal_id, $check, $reward, $report_date_for)
    {
        $this->crm_deal_id = $crm_deal_id;
        $this->check = $check;
        $this->reward = $reward;
        $this->report_date_for = $report_date_for;
    }

    public function handle(Bitrix24Api $bitrixApi): void
    {
        try {
            // Сформируем массив для обновления сделки
            $updateData = [
                'ID' => $this->crm_deal_id,
                'FIELDS' => [
                    "STAGE_ID" => 'C11:WON',
                    "UF_CRM_1450794143" => $this->reward, // Сумма агентских
                    "UF_CRM_1534334407" => $this->report_date_for, // Отчет агента за
                ],
            ];

            // Вызываем метод обновления сделки из Bitrix24Api с передачей новых значений полей
            $bitrixApi->updateDeal($updateData);

            // Здесь можно записать лог или выполнить другие действия при успешном обновлении сделки
            \Log::info('Сделка успешно обновлена', ['dealId' => $this->crm_deal_id]);
        } catch (GuzzleException $e) {
            // Обрабатываем исключения Guzzle
            \Log::error('Ошибка при обновлении сделки: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Обрабатываем другие исключения
            \Log::error('Ошибка при обновлении сделки: ' . $e->getMessage());
        }
    }
}

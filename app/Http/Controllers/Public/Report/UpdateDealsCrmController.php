<?php

namespace App\Http\Controllers\Public\Report;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateDealJob;
use App\Models\Report;
use App\Services\Bitrix24Api;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UpdateDealsCrmController extends Controller
{
    public function updateDeals($id)
    {
        $deals = Report::where('report_category_id', $id)->get();

        // Устанавливаем начальную задержку (в секундах)
        $delay = 0;

        foreach ($deals as $deal) {
            // Добавляем задачу в очередь на обновление с установленной задержкой
            UpdateDealJob::dispatch(
                $deal->crm_deal_id,
                $deal->check,
                $deal->reward,
                $deal->report_date_for
            )->delay(now()->addSeconds($delay));

            $delay += 0.6; // Увеличиваем на полсекунды
        }

        return Redirect::back()->with('success', 'Сделки добавлены в очередь.');
    }
}

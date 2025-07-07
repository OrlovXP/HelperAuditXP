<?php

namespace App\Http\Controllers\Public\Report;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Services\Bitrix24Api;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Jobs\UpdateReportJob;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;

class UpdateReportsInsideController extends Controller
{
    public function updateReports($id)
    {


        // is_statistics_synchronized

        ReportCategory::query()->update(['is_statistics_synchronized' => 1]);

        // Получаем все отчеты по заданной категории
        $reports = Report::where('report_category_id', $id)->get();

        // Устанавливаем начальную задержку (в секундах)
        $delay = 0;

        foreach ($reports as $report) {
            //if ($report->status !== 'Ready for exchange') {
                // Добавляем задачу в очередь на обновление с установленной задержкой
                UpdateReportJob::dispatch($report)->delay(now()->addSeconds($delay));

                // Увеличиваем задержку для следующей задачи
                $delay += 0.6; // Увеличиваем на полсекунды
            //}
        }

        // UpdateReportJob::dispatch($report);


        return Redirect::back()->with('success', 'Отчеты добавлены в очередь.');
    }

    public function partialUpdateReports($id)
    {

        // Получаем все отчеты по заданной категории
        $reports = Report::where('status', '<>', 'Ready for exchange')->get();


        // Устанавливаем начальную задержку (в секундах)
        $delay = 0;

        foreach ($reports as $report) {
            //if ($report->status !== 'Ready for exchange') {
            // Добавляем задачу в очередь на обновление с установленной задержкой
            UpdateReportJob::dispatch($report)->delay(now()->addSeconds($delay));

            // Увеличиваем задержку для следующей задачи
            $delay += 0.6; // Увеличиваем на полсекунды
            //}
        }

        // UpdateReportJob::dispatch($report);


        return Redirect::back()->with('success', 'Отчеты добавлены в очередь.');
    }
}

<?php

namespace App\Http\Controllers\Public\Report;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\Bitrix24Api;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Jobs\UpdateReportJob;
use Illuminate\Support\Facades\Redirect;

class UpdateReportsInsideController extends Controller
{
    public function updateReports(Request $request, $id)
    {

        // Получаем все отчеты по заданной категории
        $reports = Report::where('report_category_id', $id)->get();


        foreach ($reports as $report) {
            // Добавляем задачу в очередь на обновление
            UpdateReportJob::dispatch($report);
        }


        return Redirect::back()->with('success', 'Отчеты добавлены в очередь.');
    }


}


<?php

namespace App\Http\Controllers\Public\ReportCategory;

use App\Http\Controllers\Controller;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {

        // Находим категорию отчета по ее идентификатору
        $category = ReportCategory::findOrFail($id);

        $reports = $category->reports;

        $totalReward = 0;
        $notFoundDealsCount = 0;
        $readyForExchangeDealsCount = 0;
        $amountsNotEqualDealsCount = 0;

        foreach ($reports as $report) {
            $totalReward += $report->reward;

            switch ($report->status) {
                case 'Ready for exchange':
                    $readyForExchangeDealsCount++;
                    break;
                case 'Amounts are not equal':
                    $amountsNotEqualDealsCount++;
                    break;
                case 'Not found':
                    $notFoundDealsCount++;
                    break;
            }
        }

        // Возвращаем представление, передавая в него найденную категорию и подсчитанные статусы
        return view('public.report-categories.show', compact('category', 'reports', 'totalReward', 'notFoundDealsCount', 'readyForExchangeDealsCount', 'amountsNotEqualDealsCount'));
    }
}

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
        $totalSum = 0;
        $notFoundDealsCount = 0;
        $readyForExchangeDealsCount = 0;
        $amountsNotEqualDealsCount = 0;

        $lAgentElementsCount = 0; // Добавляем переменную для подсчета элементов L-агента
        $sAgentElementsCount = 0; // Добавляем переменную для подсчета элементов S-агента
        $dAgentElementsCount = 0; // Добавляем переменную для подсчета элементов D-агента


        $totallyLAgentElementsCount = 0;
        $totallySAgentElementsCount = 0;
        $totallyDAgentElementsCount = 0;


        foreach ($reports as $report) {
            $totalReward += $report->reward;
            $totalSum += $report->sum;


            if ($report->role === 'L-агент') {
                $totallyLAgentElementsCount++;
            }

            if ($report->role === 'S-агент') {
                $totallySAgentElementsCount++;
            }
            if ($report->role === 'D-агент') {
                $totallyDAgentElementsCount++;
            }

            switch ($report->status) {
                case 'Ready for exchange':
                    $readyForExchangeDealsCount++;
                    break;
                case 'Amounts are not equal':
                    $amountsNotEqualDealsCount++;
                    break;
                case 'Not found':
                    $notFoundDealsCount++;

                    // Подсчитываем элементы LSD агентов в отчете, если он не найден
                    if ($report->role === 'L-агент') {
                        $lAgentElementsCount++;
                    }
                    if ($report->role === 'S-агент') {
                        $sAgentElementsCount++;
                    }
                    if ($report->role === 'D-агент') {
                        $dAgentElementsCount++;
                    }
                    break;
            }
        }

        //dd($lAgentElementsCount);
        // Возвращаем представление, передавая в него найденную категорию и подсчитанные статусы
        return view('public.report-categories.show',
            compact(
                'category',
                'reports',
                'totalReward',
                'totalSum',
                'notFoundDealsCount',
                'readyForExchangeDealsCount',
                'amountsNotEqualDealsCount',
                'lAgentElementsCount',
                'sAgentElementsCount',
                'dAgentElementsCount',
                'totallyLAgentElementsCount',
                'totallySAgentElementsCount',
                'totallyDAgentElementsCount',
            ));
    }
}

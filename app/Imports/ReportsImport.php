<?php

namespace App\Imports;

use App\Jobs\UpdateReportJob;
use App\Models\Plan;
use App\Models\Report;
use App\Models\ReportCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Session;

class ReportsImport implements ToCollection
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $collection): void
    {
        $skipFirstRow = true; // Переменная для пропуска первой строки
        $previousMonth = Carbon::now()->subMonth();

        // Создаем или находим категорию отчета
        $category = ReportCategory::firstOrCreate([
            'report_date' => $previousMonth->isoFormat('MMMM YYYY')
//            'report_date' => now()
        ]);


        // Проверяем, есть ли отчеты в категории
        if ($category->reports()->exists()) {
            // Категория не пуста, отправляем сообщение об ошибке через сессию
            Session::flash('error', "Отчет за {$previousMonth->isoFormat('MMMM YYYY')} уже существует.");
            return; // Прекращаем выполнение импорта
        }


        $reportsData = []; // Массив для хранения уникальных записей

        foreach ($collection as $row) {
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue; // Пропустить первую строку
            }

            if (!isset($row[0])) {
                continue;
            }

            $check = $row[2]; // Значение поля 'check'

            $sum = is_numeric($row[3]) && !empty($row[3]) ? $row[3] : 0;
            $reward = is_numeric($row[4]) && !empty($row[4]) ? $row[4] : 0;

            // Если запись с таким 'check' уже существует, обновляем суммы
            if (isset($reportsData[$check])) {
                $reportsData[$check]['sum'] += $sum;
                $reportsData[$check]['reward'] += $reward;
            } else {
                // Создаем новую запись в массиве
                $reportsData[$check] = [
                    'inn' => $row[0],
                    'name' => $row[1],
                    'check' => $check,
                    'sum' => $sum,
                    'reward' => $reward,
                    'role' => $row[5],
                    'type' => $row[6],
                    'product' => $row[7],
                    'report_date' => $previousMonth->isoFormat('MMMM YYYY'),
                    'report_date_for' => Carbon::now()->firstOfMonth()->subMonthNoOverflow()->endOfMonth(),
                ];
            }

        }

        // Сохраняем уникальные отчеты в базу данных
        foreach ($reportsData as $reportData) {
            $report = new Report($reportData);
            $category->reports()->save($report);
        }


        // Если выполнение дошло сюда, значит импорт прошел успешно
        Session::flash('success', 'Отчет успешно импортирован.');
    }
}

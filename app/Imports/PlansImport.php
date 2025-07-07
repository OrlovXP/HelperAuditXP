<?php

namespace App\Imports;

use App\Models\Plan;
use App\Models\Registry;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PlansImport implements ToCollection
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $collection)
    {
        $collection = $collection->slice(1);

        foreach ($collection as $row) {
            if(!empty($row[0])) {
                $registry = Registry::firstWhere('ornz', $row[1]);

                if ($registry !== null) {

                    // преобразовать Excel's serial date число в формат даты PHP
                    $baseDate = \DateTime::createFromFormat('Y-m-d', '1899-12-30');
                    $interval = new \DateInterval('P'.$row[3].'D');
                    $dateToSave = $baseDate->add($interval)->format('Y-m-d');

                    Plan::create([
                        'name' => $row[0],
                        'ornz' => $row[1],
                        'verified_period' => $row[2],
                        'check_start_dates' => $dateToSave,  // использовать исправленное значение даты
                        'authorized_experts' => $row[4],
                        'review_curator' => $row[5],
                        'registry_id' => $registry->id,
                    ]);
                }
            }
        }
    }
}

<?php

namespace App\Exports;

use App\Models\Registry; // Измените на вашу модель, если она отличается
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistryExport implements FromCollection, WithHeadings
{
    // Определение заголовков для каждого столбца
    public function headings(): array
    {
        return [
            'Name',
            'INN',
            'Type',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        // выборка только нужных столбцов с join
        return DB::table('registries')  // Замените на имя вашей таблицы, если она отличается
        ->join('bitrix24_company_type', 'registries.bitrix24_company_type_id', '=', 'bitrix24_company_type.id')
            ->select('registries.name', 'registries.basic_inn', 'bitrix24_company_type.type')
            ->get();
    }

}

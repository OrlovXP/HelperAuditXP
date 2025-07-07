<?php

namespace App\Exports;

use App\Models\Registry;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistryFilterExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'Наименование организации',
            'ОРНЗ',
            'ОГРН',
            'ИНН',
            'Тип',
            'Статус АСС',
            'Нарушения',
            'Дата начала проверки',
            'Дата записи',
            'Кол-во аудиторов',
            'Пройдено ВКД',
            'Выдано заключений',
            'Прирост выданных заключений',

        ];
    }

    public function collection()
    {
        $query = $this->request->query('query');

        $bitrix24_company_type_id = $this->request->query('bitrix24_company_type_id');
        $aac_is_not_registry = $this->request->query('aac_is_not_registry');
        $aac_is_active = $this->request->query('aac_is_active');
        $aac_is_suspended = $this->request->query('aac_is_suspended');
        $aac_is_excluded = $this->request->query('aac_is_excluded');

        $from_date = $this->request->query('from_date');
        $to_date = $this->request->query('to_date');

        $from_date_recording = $this->request->query('from_date_recording');
        $to_date_recording = $this->request->query('to_date_recording');


        $ozo_is_status = $this->request->query('ozo_is_status');
        $ozofr_is_status = $this->request->query('ozofr_is_status');


        $filteredData = Registry::with('plans')->when($query, function ($query, $value) {
            $query->where('name', 'like', "%{$value}%");
        })

            ->when($aac_is_not_registry, function ($query, $value) {
                $query->orWhere('aac_is_not_registry', '=', $value);
            })
            ->when($aac_is_active, function ($query, $value) {
                $query->orWhere('aac_is_active', '=', $value);
            })
            ->when($aac_is_suspended, function ($query, $value) {
                $query->orWhere('aac_is_suspended', '=', $value);
            })
            ->when($aac_is_excluded, function ($query, $value) {
                $query->orWhere('aac_is_excluded', '=', $value);
            })
            ->when($from_date, function ($query, $value) {
                $query->whereHas('plan', function ($q) use ($value) {
                    $q->whereDate('check_start_dates', '>=', $value);
                });
            })
            ->when($to_date, function ($query, $value) {
                $query->whereHas('plan', function ($q) use ($value) {
                    $q->whereDate('check_start_dates', '<=', $value);
                });
            })

            ->when($from_date_recording, function ($query, $value) {
                return $query->whereDate('basic_date_entry_into_register', '>=', $value);
            })
            ->when($to_date_recording, function ($query, $value) {
                return $query->whereDate('basic_date_entry_into_register', '<=', $value);
            })


            ->when($bitrix24_company_type_id, function ($query, $value) {
                $query->whereIn('bitrix24_company_type_id', explode(',', $value));
            })
            ->when($ozo_is_status, function ($query, $value) {
                if ($value == "") {
                    return $query;
                } else {
                    return $query->where('ozo_is_status', '=', $value);
                }
            })
            ->when($ozofr_is_status, function ($query, $value) {
                if ($value == "") {
                    return $query;
                } else {
                    return $query->where('ozofr_is_status', '=', $value);
                }
            })
            ->join('bitrix24_company_type', 'bitrix24_company_type.id', '=', 'registries.bitrix24_company_type_id')
            ->select(
                'registries.*',  // Извлечь все поля реестра
                'bitrix24_company_type.type as bitrix24_company_type',

            )->get();


        return $filteredData->map(function ($item) {
            $item->status = $this->getStatus($item);
            $item->plan_check_start_date = $this->getCheckStartDate($item);

            unset($item->aac_is_active, $item->aac_is_suspended, $item->aac_is_excluded, $item->aac_is_not_registry, $item->plans);

            $firstNumberConclusion = $item->auditActivity->first()->number_conclusions ?? null;
            $secondNumberConclusion = $item->auditActivity->skip(1)->first()->number_conclusions ?? null;

            return [
                'Наименование организации' => $item->name,
                'ОРНЗ' => $item->ornz,
                'ОГРН' => $item->ogrn,
                'ИНН' => $item->basic_inn,
                'Тип' => $item->bitrix24_company_type,
                'Статус АСС' => $item->status,
                'Нарушения' => $item->disciplinary_type_violation ? 'Есть нарушения' : $item->disciplinary_type_violation,
                'Дата начала проверки' => $item->plan_check_start_date,
                'Дата записи' => \Carbon\Carbon::parse($item->basic_date_entry_into_register)->locale('ru')->isoFormat('D MMMM YYYY'),
                'Кол-во аудиторов' => $item->employees_count,
                'Пройдено ВКД' => max(count($item->inspections), 0),
                'Выдано заключений' => $firstNumberConclusion,
                'Прирост выданных заключений' => !empty($firstNumberConclusion) && !empty($secondNumberConclusion) ? $firstNumberConclusion - $secondNumberConclusion : 0,
            ];
        });

    }
    protected function getStatus($item): string
    {
        if ($item->aac_is_active) {
            return 'Действующие';
        } elseif ($item->aac_is_suspended) {
            return 'Приостановлено членство';
        } elseif ($item->aac_is_excluded) {
            return 'Исключены';
        } elseif ($item->aac_is_not_registry) {
            return 'Нет в реестре';
        }

        return ''; // возвращаем пустую строку, если ни одно из условий не выполнено
    }

    protected function getCheckStartDate($item): string
    {
        $dates = '';
        foreach ($item->plans as $plan) {
            if (!empty($plan->check_start_dates)) {
                $dates .= \Carbon\Carbon::parse($plan->check_start_dates)->locale('ru')->isoFormat('D MMMM YYYY') . "; ";
            }
        }

        return $dates;
    }
}

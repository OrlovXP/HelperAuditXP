<?php

namespace App\Http\Controllers\Public\AuditOrganizations;

use App\Http\Controllers\Controller;
use App\Models\Bitrix24CompanyType;
use App\Models\Registry;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //dd($request->input('bitrix24_company_type_id'));
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $fromDateRecording = $request->input('from_date_recording');
        $toDateRecording = $request->input('to_date_recording');

        $query = $request->input('query');


        $aacIsNotRegistry = $request->input('aac_is_not_registry');
        $aacIsActive = $request->input('aac_is_active');
        $aacIsSuspended = $request->input('aac_is_suspended');
        $aacIsExcluded = $request->input('aac_is_excluded');


        $violationExists = $request->input('violationExists');
        $ozoIsStatus = $request->input('ozo_is_status');
        $ozofrIsStatus = $request->input('ozofr_is_status');

        // Создаем запрос
        $registers = Registry::query();

        if ($violationExists) {
            $registers->whereNotNull('disciplinary_type_violation');
        }

        if ($aacIsActive || $aacIsSuspended || $aacIsNotRegistry || $aacIsExcluded) {
            $registers->where(function ($query) use ($aacIsActive, $aacIsSuspended, $aacIsNotRegistry, $aacIsExcluded) {
                if ($aacIsActive) {
                    $query->orWhere('aac_is_active', 1);
                }
                if ($aacIsSuspended) {
                    $query->orWhere('aac_is_suspended', 1);
                }
                if ($aacIsNotRegistry) {
                    $query->orWhere('aac_is_not_registry', 1);
                }
                if ($aacIsExcluded) {
                    $query->orWhere('aac_is_excluded', 1);
                }
            });
        }


        if ($ozoIsStatus !== null) {
            if ($ozoIsStatus === '') {
                $ozoIsStatus = null;
            } else {
                $ozoIsStatus = boolval($ozoIsStatus);
            }
            $registers->where('ozo_is_status', $ozoIsStatus);
        }


        if ($ozofrIsStatus !== null) {
            if ($ozofrIsStatus === '') {
                $ozofrIsStatus = null;
            } else {
                $ozofrIsStatus = boolval($ozofrIsStatus);
            }
            $registers->where('ozofr_is_status', $ozofrIsStatus);
        }

        // Фильтрация по name или basic_inn если присутствует $query
        if ($query) {
            $registers->where('name', 'like', "%{$query}%")
                ->orWhere('basic_inn', 'like', "%{$query}%");
        }

        // Фильтрация по bitrix24_company_type_id если он присутствует
        if ($request->input('bitrix24_company_type_id')) {
            $registers->whereIn('bitrix24_company_type_id', $request->input('bitrix24_company_type_id'));
        }

        // Фильтрация по датам планов, если они установлены
        if($fromDate && $toDate) {
            $registers->whereHas('plans', function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('check_start_dates', [$fromDate, $toDate]);
            });
        } elseif ($fromDate) {
            $registers->whereHas('plans', function ($query) use ($fromDate) {
                $query->where('check_start_dates', '>=', $fromDate);
            });
        } elseif ($toDate) {
            $registers->whereHas('plans', function ($query) use ($toDate) {
                $query->where('check_start_dates', '<=', $toDate);
            });
        }

        if($fromDateRecording && $toDateRecording) {
            $registers->whereBetween('basic_date_entry_into_register', [$fromDateRecording, $toDateRecording]);
        } elseif ($fromDateRecording) {
            $registers->where('basic_date_entry_into_register', '>=', $fromDateRecording);
        } elseif ($toDateRecording) {
            $registers->where('basic_date_entry_into_register', '<=', $toDateRecording);
        }

        // Получаем результаты
        $registers = $registers->with('plans')->paginate(100);

        $companyTypes = Bitrix24CompanyType::all();

        $data = compact('registers', 'companyTypes', 'violationExists', 'aacIsNotRegistry', 'aacIsActive', 'aacIsSuspended', 'aacIsExcluded', 'ozoIsStatus', 'ozofrIsStatus');
        $request->flash();
//        return view('public.audit-organizations.index', $data)->withInput();
        return view('public.audit-organizations.index', $data);
    }
}

<?php

namespace App\Http\Controllers\Public\ReportCategory;

use App\Http\Controllers\Controller;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

class UpdaterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {

        $category = ReportCategory::findOrFail($id);

        $category->update($request->only([
            'total_sum',
            'total_reward',
            'total_deals',
            'total_l_deals',
            'total_s_deals',
            'total_d_deals',
            'crm_full_compliance',
            'crm_partial_compliance',
            'crm_no_deals',
            'crm_no_l_deals',
            'crm_no_s_deals',
            'crm_no_d_deals',
            'is_statistics_saved',
        ]));

        return redirect()->route('report-categories.show', $id)->with('success', 'Статистика сохранена.');


    }
}

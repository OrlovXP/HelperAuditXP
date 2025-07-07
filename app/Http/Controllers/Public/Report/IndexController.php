<?php

namespace App\Http\Controllers\Public\Report;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Report;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $reports = Report::all();

        return view('public.reports.index', compact('reports'));
    }
}

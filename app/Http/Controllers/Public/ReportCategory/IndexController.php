<?php

namespace App\Http\Controllers\Public\ReportCategory;

use App\Http\Controllers\Controller;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = ReportCategory::orderByDesc('created_at')->get();

        return view('public.report-categories.index', compact('categories'));
    }
}

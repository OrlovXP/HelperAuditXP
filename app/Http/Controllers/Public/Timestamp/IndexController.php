<?php

namespace App\Http\Controllers\Public\Timestamp;

use App\Http\Controllers\Controller;
use App\Models\NewsTimestamp;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $timestamps = NewsTimestamp::all();
        return view('public.timestamps.index', compact('timestamps'));
    }
}

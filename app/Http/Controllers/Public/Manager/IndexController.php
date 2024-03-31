<?php

namespace App\Http\Controllers\Public\Manager;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $managers = Manager::all();

        return view('public.managers.index', compact('managers'));
    }
}


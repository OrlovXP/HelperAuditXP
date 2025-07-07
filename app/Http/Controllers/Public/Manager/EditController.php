<?php

namespace App\Http\Controllers\Public\Manager;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Manager $manager)
    {

        return view('public.managers.edit', compact('manager'));

    }
}


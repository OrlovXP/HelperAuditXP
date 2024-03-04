<?php

namespace App\Http\Controllers\Public\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $users = User::all();

        return view('public.users.index', compact('users'));
    }
}

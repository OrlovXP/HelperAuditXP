<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\StoreRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return redirect()->route('index');
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');

    }

}

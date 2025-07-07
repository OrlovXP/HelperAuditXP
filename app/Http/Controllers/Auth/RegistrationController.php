<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Registration\StoreRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        User::query()->create($data);

        return redirect()->route('login');
    }
}

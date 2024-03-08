<?php

namespace App\Http\Controllers\Public\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ToggleActivationController extends Controller
{
    /**
     * Handle the incoming request to toggle user activation status.
     */
    public function __invoke(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Переключение статуса активации пользователя
        $user->is_active = !$user->is_active;
        $user->save();

        $message = $user->is_active ? 'Пользователь успешно активирован.' : 'Пользователь успешно деактивирован.';

        return redirect()->route('users.index', $id)->with('success', $message);
    }
}

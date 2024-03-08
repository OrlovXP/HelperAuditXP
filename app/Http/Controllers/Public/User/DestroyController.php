<?php

namespace App\Http\Controllers\Public\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        // Найдем пользователя по его идентификатору
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index', $id)->with('success', 'Пользователь успешно удален.');

    }
}

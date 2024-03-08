<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Проверяем, имеет ли текущий пользователь одну из заданных ролей
        if (in_array($request->user()->role->name, $roles, true)) {
            return $next($request);
        }

        // Если пользователь не имеет заданных ролей, перенаправляем его или возвращаем ошибку
        return redirect()->route('index')->with('error', 'Недостаточно прав доступа.');
    }
}

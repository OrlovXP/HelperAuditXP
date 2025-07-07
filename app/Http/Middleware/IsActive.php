<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Route::currentRouteName() !== 'index') {
            // Проверяем, активен ли пользователь
            if (!$request->user()->is_active) {
                // Если пользователь не активен, перенаправляем его или возвращаем ошибку
                return redirect()->route('login')->with('error', 'Ваш аккаунт не активирован.');
            }
        }

        return $next($request);
    }
}

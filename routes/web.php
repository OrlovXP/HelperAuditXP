<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Controllers\Public\IndexController::class, 'index')->name('index');
    Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class)->name('logout');


    Route::middleware('role:admin')->group(function () {
        // Управление пользователями
        Route::get('/users', \App\Http\Controllers\Public\User\IndexController::class)->name('users.index');

        Route::put('users/{id}/deactivate', \App\Http\Controllers\Public\User\ToggleActivationController::class)
            ->name('users.toggle-activation');

        Route::put('/users/{id}', \App\Http\Controllers\Public\User\UpdaterController::class)->name('users.update');
        Route::delete('/users/{id}', \App\Http\Controllers\Public\User\DestroyController::class)->name('users.destroy');
    });






    Route::post('/import', \App\Http\Controllers\Public\Excel\ImportController::class)->name('import');

    Route::get('/reports',
        \App\Http\Controllers\Public\ReportCategory\IndexController::class)->name('report-categories.index');
    Route::delete('/reports/{id}',
        \App\Http\Controllers\Public\ReportCategory\DestroyController::class)->name('report-categories.destroy');
    Route::get('/reports/{id}',
        \App\Http\Controllers\Public\ReportCategory\ShowController::class)->name('report-categories.show');
    Route::put('/reports/{id}',
        \App\Http\Controllers\Public\ReportCategory\UpdaterController::class)->name('report-categories.update');


    Route::get('/update-reports/{id}', [
        \App\Http\Controllers\Public\Report\UpdateReportsInsideController::class, 'updateReports'
    ])->name('update.reports');



// Управление продуктами
    Route::get('/products', \App\Http\Controllers\Public\Product\IndexController::class)->name('products.index');

    Route::get('/test', [\App\Http\Controllers\Public\TestController::class, 'testMethod'])->name('test');
});

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', \App\Http\Controllers\Auth\LoginController::class)->name('login.store');

    Route::view('/registration', 'auth.registration')->name('registration');
    Route::post('/registration', \App\Http\Controllers\Auth\RegistrationController::class)->name('registration.store');
});




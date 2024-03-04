<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('/', \App\Http\Controllers\Public\IndexController::class, 'index')->name('index');
    Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class)->name('logout');

    Route::get('/users', \App\Http\Controllers\Public\User\IndexController::class)->name('users.index');


    Route::post('/import', \App\Http\Controllers\Public\Excel\ImportController::class)->name('import');

    Route::get('/reports', \App\Http\Controllers\Public\ReportCategory\IndexController::class)->name('report-categories.index');
    Route::delete('/reports/{id}', \App\Http\Controllers\Public\ReportCategory\DestroyController::class)->name('report-categories.destroy');
    Route::get('/reports/{id}', \App\Http\Controllers\Public\ReportCategory\ShowController::class)->name('report-categories.show');



    Route::get('/update-reports/{id}', [\App\Http\Controllers\Public\Report\UpdateReportsInsideController::class, 'updateReports'])->name('update.reports');

// Route::match(['get', 'post'],'/update-reports/{$id}', [\App\Http\Controllers\Public\Report\UpdateReportsInsideController::class, 'updateReports'])->name('update.reports');

    Route::get('/test', [\App\Http\Controllers\Public\TestController::class, 'testMethod'])->name('test');

});

Route::middleware('guest')->group(function () {

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', \App\Http\Controllers\Auth\LoginController::class)->name('login.store');

    Route::view('/registration', 'auth.registration')->name('registration');
    Route::post('/registration', \App\Http\Controllers\Auth\RegistrationController::class)->name('registration.store');

});




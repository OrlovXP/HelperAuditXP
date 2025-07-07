<?php

use App\Exports\RegistryExport;
use App\Exports\RegistryFilterExport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Controllers\Public\IndexController::class)->name('index');
    Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class)->name('logout');


    Route::middleware('role:admin,manager')->group(function () {
        // Управление пользователями
        Route::get('/users', \App\Http\Controllers\Public\User\IndexController::class)->name('users.index');

        Route::put('users/{id}/deactivate', \App\Http\Controllers\Public\User\ToggleActivationController::class)
            ->name('users.toggle-activation');

        Route::put('/users/{id}', \App\Http\Controllers\Public\User\UpdaterController::class)->name('users.update');
        Route::delete('/users/{id}', \App\Http\Controllers\Public\User\DestroyController::class)->name('users.destroy');

        // Управление продуктами
        Route::get('/products', \App\Http\Controllers\Public\Product\IndexController::class)->name('products.index');
        Route::get('/products/create',
            \App\Http\Controllers\Public\Product\CreateController::class)->name('products.create');
        Route::post('/products', \App\Http\Controllers\Public\Product\StoreController::class)->name('products.store');
        Route::get('/products/{product}/edit',
            \App\Http\Controllers\Public\Product\EditController::class)->name('products.edit');
        Route::put('/products/{product}/update',
            \App\Http\Controllers\Public\Product\UpdateController::class)->name('products.update');
        Route::delete('/products/{product}',
            \App\Http\Controllers\Public\Product\DeleteController::class)->name('products.destroy');


// Управление менеджерами
        Route::get('/managers', \App\Http\Controllers\Public\Manager\IndexController::class)->name('managers.index');
        Route::get('/managers/create',
            \App\Http\Controllers\Public\Manager\CreateController::class)->name('managers.create');
        Route::post('/managers', \App\Http\Controllers\Public\Manager\StoreController::class)->name('managers.store');
        Route::get('/managers/{manager}/edit',
            \App\Http\Controllers\Public\Manager\EditController::class)->name('managers.edit');
        Route::put('/managers/{manager}/update',
            \App\Http\Controllers\Public\Manager\UpdateController::class)->name('managers.update');
        Route::delete('/managers/{manager}',
            \App\Http\Controllers\Public\Manager\DeleteController::class)->name('managers.destroy');

        Route::get('/timestamps',
            \App\Http\Controllers\Public\Timestamp\IndexController::class)->name('timestamp.index');

        Route::delete('/reports/{id}',
            \App\Http\Controllers\Public\ReportCategory\DestroyController::class)->name('report-categories.destroy');


// Управление организациями
        Route::get('/audit-organizations', \App\Http\Controllers\Public\AuditOrganizations\IndexController::class)->name('audit-organizations.index');
        Route::get('/audit-organizations/{basic_inn}', \App\Http\Controllers\Public\AuditOrganizations\ShowController::class)->name('audit-organizations.show');
        Route::get('/audit-organizations-parser', \App\Http\Controllers\Public\AuditOrganizations\ParserController::class)->name('audit-organizations.parser');
        Route::post('/audit-organizations/{basic_inn}',
            \App\Http\Controllers\Public\AuditOrganizations\UpdateController::class)->name('audit-organizations.update');

    });


    Route::post('/import', \App\Http\Controllers\Public\Excel\ImportController::class)->name('import');
    Route::post('/import-plan', \App\Http\Controllers\Public\Plans\ImportController::class)->name('import-plan');
//    Route::get('/export', function () {
//        return Excel::download(new RegistryExport, 'registers.xlsx');
//    });

    Route::get('/export-filter', function (Request $request) {
        return Excel::download(new RegistryFilterExport($request), 'registries_export.xlsx');
    });

    Route::get('/reports',
        \App\Http\Controllers\Public\ReportCategory\IndexController::class)->name('report-categories.index');
    Route::get('/reports/{id}',
        \App\Http\Controllers\Public\ReportCategory\ShowController::class)->name('report-categories.show');
    Route::put('/reports/{id}',
        \App\Http\Controllers\Public\ReportCategory\UpdaterController::class)->name('report-categories.update');

    Route::get('/update-reports/{id}', [
        \App\Http\Controllers\Public\Report\UpdateReportsInsideController::class, 'updateReports'
    ])->name('update.reports');

    Route::get('/partial-update-reports/{id}', [
        \App\Http\Controllers\Public\Report\UpdateReportsInsideController::class, 'partialUpdateReports'
    ])->name('partial-update.reports');


    //partial update


    Route::get('/update-deals/{id}', [
        \App\Http\Controllers\Public\Report\UpdateDealsCrmController::class, 'updateDeals'
    ])->name('update.deals');


    Route::get('/test-bitrix',
        [\App\Http\Controllers\Public\TestBitrixController::class, 'testMethod'])->name('test.bitrix');
    Route::get('/test-billy',
        [\App\Http\Controllers\Public\TestBillyController::class, 'testMethod'])->name('test.billy');

    Route::post('/deals-print', \App\Http\Controllers\Public\Tools\PrintController::class)->name('deals.print');

    Route::get('/deals-print', \App\Http\Controllers\Public\Tools\PrintController::class)->name('deals.print');

    Route::get('/test', \App\Http\Controllers\TestController::class)->name('test');
});

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', \App\Http\Controllers\Auth\LoginController::class)->name('login.store');

    Route::view('/registration', 'auth.registration')->name('registration');
    Route::post('/registration', \App\Http\Controllers\Auth\RegistrationController::class)->name('registration.store');
});

// audit-organizations

//php artisan make:controller Public/AuditOrganizations/UpdateController --invokable

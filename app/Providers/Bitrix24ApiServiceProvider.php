<?php

namespace App\Providers;

use App\Services\Bitrix24Api;
use Illuminate\Support\ServiceProvider;

class Bitrix24ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Bitrix24Api::class, function ($app) {
            return new Bitrix24Api(new \GuzzleHttp\Client());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/bitrix24.php' => config_path('bitrix24.php'),
        ], 'config');
    }
}

<?php

namespace App\Providers;

use App\Services\CurrencyRate\Api\ApiInterface;
use App\Services\CurrencyRate\Api\SberApi;
use App\Services\CurrencyRate\GetRateService;
use App\Services\CurrencyRate\GetRateServiceInterface;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiInterface::class, SberApi::class);

        $this->app->singleton(GetRateServiceInterface::class, GetRateService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

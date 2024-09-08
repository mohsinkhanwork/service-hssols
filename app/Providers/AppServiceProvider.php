<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PeachPaymentService;
use Shaz3e\PeachPayment\Helpers\PeachPayment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PeachPayment::class, PeachPaymentService::class);
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

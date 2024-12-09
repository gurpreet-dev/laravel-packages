<?php

namespace Gptinker\GoogleMerchant;

use Gptinker\GoogleMerchant\Services\ProductApiService;
use Illuminate\Support\ServiceProvider;

class GoogleMerchantServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('product-api-service', function () {
            return new ProductApiService();
        });
    }

    public function boot()
    {
        //
    }
}

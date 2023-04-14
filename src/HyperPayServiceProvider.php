<?php

namespace HossamMonir\HyperPay;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class HyperPayServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register a class in the service container
        $this->app->bind('HyperPay', function () {
            return new HyperPay();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //h HyperPay services config to the application config
        $this->publishes([
            __DIR__.'/config/hyperpay.php' => config_path('hyperpay.php'),
        ]);

        $loader = AliasLoader::getInstance();
        $loader->alias('HyperPay', 'HossamMonir\\HyperPay\\Facades\\HyperPay');
    }
}

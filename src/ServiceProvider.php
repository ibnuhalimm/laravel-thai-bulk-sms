<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

use Ibnuhalimm\LaravelThaiBulkSms\Exceptions\InvalidConfigException;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('thai-bulk-sms.php'),
            ], 'thai-bulk-sms-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'thai-bulk-sms');

        $this->app->bind(ThaiBulkSmsConfig::class, function () {
            return new ThaiBulkSmsConfig($this->app['config']['thai-bulk-sms']);
        });

        $this->app->singleton(ThaiBulkSmsClient::class, function (Application $app) {
            $config = $app->make(ThaiBulkSmsConfig::class);

            if ($config->getApiKey() && $config->getSecretKey()) {
                return new ThaiBulkSmsClient($config);
            }

            throw InvalidConfigException::missingApiAndSecretKey();
        });

        $this->app->singleton(ThaiBulkSmsChannel::class, function (Application $app) {
            return new ThaiBulkSmsChannel(
                $app->make(ThaiBulkSms::class)
            );
        });

        // Register main class to use with the facade
        $this->app->singleton(ThaiBulkSms::class, function (Application $app) {
            return new ThaiBulkSms(
                $app->make(ThaiBulkSmsClient::class),
            );
        });
    }
}

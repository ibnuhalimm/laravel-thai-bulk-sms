<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

use Ibnuhalimm\LaravelThaiBulkSms\Exceptions\InvalidConfigException;
use Ibnuhalimm\LaravelThaiBulkSms\Services\HttpClient;
use Ibnuhalimm\LaravelThaiBulkSms\Services\ThaiBulkSms;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ThaiBulkSmsServiceProvider extends ServiceProvider
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

        $this->app->bind(ConfigRepository::class, function () {
            return new ConfigRepository($this->app['config']['thai-bulk-sms']);
        });

        $this->app->singleton(HttpClient::class, function (Application $app) {
            $config = $app->make(ConfigRepository::class);

            if ($config->getApiKey() && $config->getSecretKey()) {
                return new HttpClient($config);
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
                $app->make(HttpClient::class),
            );
        });
    }
}

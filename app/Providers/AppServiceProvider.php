<?php

namespace App\Providers;

ini_set('memory_limit', '-1');

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\BusinessSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrap();

        /**
         * Force HTTPS in production (Railway requires this)
         */
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        /**
         * Dynamic timezone logic
         */
        try {
            $timezone = BusinessSetting::where(['key' => 'time_zone'])->first();
            if ($timezone && $timezone->value) {
                config(['app.timezone' => $timezone->value]);
                date_default_timezone_set($timezone->value);
            }
        } catch (\Exception $exception) {
            // Ignore timezone errors
        }
    }
}

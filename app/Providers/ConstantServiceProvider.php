<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConstantServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Map TELEPHONE_CODES constant
        if (!defined('TELEPHONE_CODES')) {
            define('TELEPHONE_CODES', config('constant.telephone_codes'));
        }

        // Map TIME_ZONE constant
        if (!defined('TIME_ZONE')) {
            define('TIME_ZONE', config('constant.time_zone'));
        }

        // Map MODULE_PERMISSION constant
        if (!defined('MODULE_PERMISSION')) {
            define('MODULE_PERMISSION', config('constant.module_permission'));
        }
    }
}

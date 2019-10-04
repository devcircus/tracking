<?php

namespace App\Providers;

use Debugbar;
use Illuminate\Support\ServiceProvider;

class DebugbarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        Debugbar::disable();

        if (! config('app.debug')) {
            Debugbar::disable();
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}

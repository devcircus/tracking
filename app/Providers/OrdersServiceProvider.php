<?php

namespace App\Providers;

use App\Models\Type;
use Illuminate\Support\ServiceProvider;

class OrdersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->app->singleton('orders', function ($app) {
            return collect([
                'bag' => 'bag',
                'late' => 'late',
                'new' => 'new',
                'production' => 'production',
                'prototype' => 'prototype',
                'rush' => 'rush',
            ]);
        });

        $this->app->singleton('types', function ($app) {
            return collect([
                'bag' => Type::where('type', 'bag')->first(),
                'late' => Type::where('type', 'late')->first(),
                'new' => Type::where('type', 'new')->first(),
                'production' => Type::where('type', 'production')->first(),
                'prototype' => Type::where('type', 'prototype')->first(),
                'rush' => Type::where('type', 'rush')->first(),
            ]);
        });
    }
}

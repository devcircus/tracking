<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function (?User $user = null) {
            return in_array($user->email, [
                Config::get('auth.admin.email'),
            ]);
        });
    }
}

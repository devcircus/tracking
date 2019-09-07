<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\User;
use App\Policies\ItemPolicy;
use App\Models\InventoryItem;
use App\Policies\InventoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $policies = [
        Tag::class => InventoryPolicy::class,
        InventoryItem::class => ItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-user', function ($authenticated, $user) {
            return $authenticated->id === $user->id || $this->checkAdmins($authenticated);
        });
    }

    /**
     * Check if the currently authenticated user is an administrator.
     *
     * @param  \App\Models\User  $authenticated
     *
     * @return bool
     */
    public function checkAdmins(User $authenticated)
    {
        return in_array($authenticated->email, [
            Config::get('auth.admin.email'),
        ]);
    }
}

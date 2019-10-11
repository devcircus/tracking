<?php

namespace App\Providers;

use App\Models\User;
use ReflectionClass;
use Illuminate\Support\Str;
use App\Authorization\Policies;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $policies = [];

    /** @var array */
    protected $policyNames = [];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('update-user', function ($authenticated, $user) {
            return $authenticated->id === $user->id || $this->checkAdmins($authenticated);
        });

        $this->enactPolicies();
    }

    /**
     * Check if the currently authenticated user is an administrator.
     *
     * @param  \App\Models\User  $authenticated
     */
    public function checkAdmins(User $authenticated): bool
    {
        return in_array($authenticated->email, [
            Config::get('auth.admin.email'),
        ]);
    }

    /**
     * Enact all policies.
     */
    private function enactPolicies(): void
    {
        $this->app->singleton(Policies::class, function ($app) {
            return new Policies;
        });

        $reflectionClass = new ReflectionClass(Policies::class);
        resolve(Policies::class)->setPolicies($reflectionClass->getConstants());

        $this->enactItemPolicies();
        $this->enactTagPolicies();
        $this->enactFabricPolicies();
        $this->enactInkPolicies();
        $this->enactPrinterPolicies();
        $this->enactColorPolicies();
        $this->enactReportPolicies();
        $this->enactActivityPolicies();
    }

    /**
     * Get the policy names.
     */
    public function getPolicyNames(): array
    {
        return resolve(Policies::class)->getPolicies();
    }

    /**
     * Enact the policies for items.
     */
    private function enactItemPolicies(): void
    {
        $itemAbilities = collect($this->getPolicyNames())->filter(function ($ability) {
            return Str::endsWith($ability, 'Items');
        })->toArray();

        foreach($itemAbilities as $key => $policy) {
            Gate::define($policy, function ($user) {
                return $user->is_admin;
            });
        }
    }

    /**
     * Enact the policies for inventory tags.
     */
    private function enactTagPolicies(): void
    {
        Gate::define(Policies::ADMINISTER_TAGS, function($user) {
            return $user->is_super_admin;
        });

        Gate::define(Policies::DELETE_TAGS, function($user) {
            return $user->is_super_admin;
        });

        Gate::define(Policies::RESTORE_TAGS, function($user) {
            return $user->is_super_admin;
        });

        Gate::define(Policies::ACTIVATE_TAGS, function($user) {
            return true;
        });

        Gate::define(Policies::FINISH_TAGS, function($user) {
            return true;
        });
    }

    /**
     * Enact the policies for reports.
     */
    private function enactReportPolicies(): void
    {
        Gate::define(Policies::ADMINISTER_REPORTS, function ($user) {
            return $user->is_super_admin;
        });
    }

    /**
     * Enact the policies for activities.
     */
    private function enactActivityPolicies(): void
    {
        Gate::define(Policies::ADMINISTER_ACTIVITIES, function ($user) {
            return $user->is_super_admin;
        });
    }

    /**
     * Enact the policies for inks.
     */
    private function enactInkPolicies(): void
    {
        $inkAbilities = collect($this->getPolicyNames())->filter(function ($ability) {
            return Str::endsWith($ability, 'Inks');
        })->toArray();

        foreach($inkAbilities as $key => $policy) {
            Gate::define($policy, function ($user) {
                return $user->is_admin;
            });
        }
    }

    /**
     * Enact the policies for colors.
     */
    private function enactColorPolicies(): void
    {
        $colorAbilities = collect($this->getPolicyNames())->filter(function ($ability) {
            return Str::endsWith($ability, 'Colors');
        })->toArray();

        foreach($colorAbilities as $key => $policy) {
            Gate::define($policy, function ($user) {
                return $user->is_admin;
            });
        }
    }

    /**
     * Enact the policies for fabrics.
     */
    private function enactFabricPolicies(): void
    {
        $fabricAbilities = collect($this->getPolicyNames())->filter(function ($ability) {
            return Str::endsWith($ability, 'Fabrics');
        })->toArray();

        foreach($fabricAbilities as $key => $policy) {
            Gate::define($policy, function ($user) {
                return $user->is_admin;
            });
        }
    }

    /**
     * Enact the policies for printers.
     */
    private function enactPrinterPolicies(): void
    {
        $printerAbilities = collect($this->getPolicyNames())->filter(function ($ability) {
            return Str::endsWith($ability, 'Printers');
        })->toArray();

        foreach($printerAbilities as $key => $policy) {
            Gate::define($policy, function ($user) {
                return $user->is_admin;
            });
        }
    }
}

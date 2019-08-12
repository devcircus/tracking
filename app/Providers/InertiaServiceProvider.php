<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Services\Tag\ListTagsService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Services\Item\ListItemsService;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->shareWithInertia();
    }

    /**
     * Configure and share data with Inertia.
     */
    protected function shareWithInertia()
    {
        Inertia::version(static function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share('app.name', Config::get('app.name'));

        Inertia::share('errors', static function () {
            if ($errors = Session::get('errors')) {
                $bags = $errors->getBags();

                return collect($bags)->map(function ($bag, $key) {
                    return $bag->getMessages();
                });
            }

            return (object) [];
        });

        Inertia::share('success', static function () {
            return [
                'success' => Session::get('success'),
            ];
        });

        Inertia::share('warning', static function () {
            return [
                'warning' => Session::get('warning'),
            ];
        });

        Inertia::share('info', static function () {
            return [
                'info' => Session::get('info'),
            ];
        });

        Inertia::share('session', static function () {
            return [
                'session' => Session::get('session'),
            ];
        });

        Inertia::share('items', static function () {
            if (Auth::user()) {
                return ListItemsService::call();
            }
        });

        Inertia::share('tags', static function () {
            if (Auth::user()) {
                return ListTagsService::call();
            }
        });

        Inertia::share('auth.user', static function () {
            if ($user = Auth::user()) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin,
                    'deleted_at' => $user->deleted_at,
                ];
            }
        });
    }
}

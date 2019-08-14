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

        Inertia::share([
            'auth' => function () {
                $user = Auth::user();
                return [
                    'user' => $user ? [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_admin' => $user->is_admin,
                        'deleted_at' => $user->deleted_at,
                    ] : null,
                ];
            },
            'app' => static function () {
                return [
                    'name' => Config::get('app.name'),
                ];
            },
            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                ];
            },
            'errors' => function () {
                if ($errors = Session::get('errors')) {
                    $bags = $errors->getBags();

                    return collect($bags)->map(function ($bag, $key) {
                        return $bag->getMessages();
                    });
                }

                return (object) [];
            },
            'success' => static function () {
                return [
                    'success' => Session::get('success'),
                ];
            },
            'warning' => static function () {
                return [
                    'warning' => Session::get('warning'),
                ];
            },
            'info' => static function () {
                return [
                    'info' => Session::get('info'),
                ];
            },
            'session' => static function () {
                return [
                    'session' => Session::get('session'),
                ];
            },
            'items' => static function () {
                if (Auth::user()) {
                    return ListItemsService::call();
                }
            },
            'tags' => static function () {
                if (Auth::user()) {
                    return ListTagsService::call();
                }
            },
        ]);
    }
}

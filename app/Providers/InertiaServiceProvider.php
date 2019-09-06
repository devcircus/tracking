<?php

namespace App\Providers;

use App\Models\Tag;
use Inertia\Inertia;
use App\Policies\ItemPolicy;
use App\Models\InventoryItem;
use App\Models\User;
use App\Policies\InventoryPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

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
        $this->shareAssetVersion();

        $this->shareAuthenticatedUser();

        $this->shareAppData();

        $this->shareFlashMessages();

        $this->shareFormErrors();
    }

    /**
     * Share current asset version.
     */
    private function shareAssetVersion(): void
    {
        Inertia::version(static function () {
            return md5_file(public_path('mix-manifest.json'));
        });
    }

    /**
     * Share the currently authenticated user.
     */
    private function shareAuthenticatedUser(): void
    {
        Inertia::share([
            'auth' => static function () {
                $user = Auth::user();

                return [
                    'user' => $user ? [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_admin' => $user->is_admin,
                        'is_artist' => $user->is_artist,
                        'deleted_at' => $user->deleted_at,
                        'can' => $user->getAuthorizationDetails(),
                    ] : null,
                ];
            },
        ]);
    }

    /**
     * Share relevant application data.
     */
    private function shareAppData(): void
    {
        Inertia::share([
            'app' => static function () {
                return [
                    'name' => Config::get('app.name'),
                ];
            },
        ]);
    }

    /**
     * Share session flash messages.
     */
    private function shareFlashMessages(): void
    {
        Inertia::share([
            'flash' => static function () {
                return [
                    'success' => Session::get('success'),
                ];
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
        ]);
    }

    /**
     * Share form errors.
     */
    private function shareFormErrors(): void
    {
        Inertia::share([
            'errors' => static function () {
                if ($errors = Session::get('errors')) {
                    $bags = $errors->getBags();

                    return collect($bags)->map(static function ($bag, $key) {
                        return $bag->getMessages();
                    });
                }

                return (object) [];
            },
        ]);
    }
}

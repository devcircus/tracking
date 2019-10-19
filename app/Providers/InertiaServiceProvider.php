<?php

namespace App\Providers;

use Breadcrumbs;
use Inertia\Inertia;
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

        $this->shareBreadcrumbs();
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
                        'is_super_admin' => $user->is_super_admin,
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
            'success' => static function () {
                $success = Session::get('flash_message')['success'] ?? null;

                return [
                    'message' => $success ? $success['message'] : null,
                    'class' => $success ? $success['class'] : null,
                ];
            },
            'warning' => static function () {
                $warning = Session::get('flash_message')['warning'] ?? null;

                return [
                    'message' => $warning ? $warning['message'] : null,
                    'class' => $warning ? $warning['class'] : null,
                ];
            },
            'info' => static function () {
                $info = Session::get('flash_message')['info'] ?? null;

                return [
                    'message' => $info ? $info['message'] : null,
                    'class' => $info ? $info['class'] : null,
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

    /**
     * Share breadcrumbs.
     */
    private function shareBreadcrumbs(): void
    {
        Inertia::share([
            'breadcrumbs' => static function () {
                $breadcrumbs = Breadcrumbs::generate();

                if (count($breadcrumbs)) {
                    return $breadcrumbs;
                }

                return [];
            },
        ]);
    }
}

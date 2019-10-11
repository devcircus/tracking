<?php

namespace App\Http\Actions\Auth\Logout;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\StatefulGuard;

class ProcessLogout extends Action
{
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard();
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function loggedOut(Request $request): RedirectResponse
    {
        return redirect()->route('dashboard')->with(['success' => 'Logged out!']);
    }
}

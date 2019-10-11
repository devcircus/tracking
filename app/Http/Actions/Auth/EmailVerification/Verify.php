<?php

namespace App\Http\Actions\Auth\EmailVerification;

use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;

class Verify extends Action
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed');
        $this->middleware('throttle:6,1');
    }

    /**
     * Verify the user via their email address.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        throw_unless($request->targetUserIsSelf(), AuthorizationException::class);

        redirect_if($user->hasVerifiedEmail(), route('dashboard'), ['info' => 'User already verified.']);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('dashboard')->with(['success' => 'Thank you for verifying your account.']);
    }
}

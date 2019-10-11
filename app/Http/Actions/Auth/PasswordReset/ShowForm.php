<?php

namespace App\Http\Actions\Auth\PasswordReset;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use PerfectOblivion\Actions\Action;

class ShowForm extends Action
{
    /**
     * Display the password reset view for the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     */
    public function __invoke(Request $request, ?string $token = null): Response
    {
        return Inertia::render('Auth/PasswordReset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
}

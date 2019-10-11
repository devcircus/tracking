<?php

namespace App\Http\Actions\Auth\PasswordResetRequest;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Actions\Action;

class ShowForm extends Action
{
    /**
     * Show the password reset request form.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Auth/PasswordResetRequest');
    }
}

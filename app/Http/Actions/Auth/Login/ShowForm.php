<?php

namespace App\Http\Actions\Auth\Login;

use Inertia\Inertia;
use Inertia\Response;
use PerfectOblivion\Actions\Action;

class ShowForm extends Action
{
    /**
     * Show the login form.
     */
    public function __invoke(): Response
    {
        return Inertia::render('Auth/Login');
    }
}
